

public function create(Request $r)
    {
        try {
            $user = auth()->user();
            if (!$user->can('create', Chartofaccount::class)) {
                return response(['errors' => ['authError' => ["User is not authorized for this action"]], 'status' => false, 'message' => ''], 422);
            }

            if (!$r->document) {
                return response(['errors' => ['document' => ["Uno file found"]], 'status' => false, 'message' => ''], 422);
            }
            $file_data = $r->document['data'];
            $owner_id = $user->owner_id ? $user->owner_id : $user->id;
            $basePath = sprintf(config('app.debit_path'), $owner_id, 1);
            $file_name = $basePath . time().'-'.$r->document['name'];
            @list($type, $file_data) = explode(';', $file_data);
            @list(, $file_data) = explode(',', $file_data);
            if ($file_data != "") {
                $path  = \Storage::disk('local')->put($file_name, base64_decode($file_data));
            }
            $datas  = [];
            $collections = Excel::toCollection(new ChartofaccountImport, $file_name, 'local');
            foreach ($collections[0] as $key => $colection) {
                if ($key > 0 and $key < count($collections[0]) - 1) {
                    $datas_explode = array_reverse(explode(':',$colection[0]))[0];
                    $code = substr($datas_explode, 0, 4);
                    $name = substr($datas_explode, 5);
                    if ($code and  $name and $colection[1]) {
                        $datas [] = [
                            'name'       => $name,
                            'code'       => $code,
                            'type'       => $colection[1],
                            'user_id'    => $owner_id,
                            'isActive'   => 1,
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }
                    
                } 
            }
            if (count($datas) == 0) {
                \Storage::disk('local')->delete($file_name);
                return response(['errors' => ['chartofaccount' => ['no record found or invalid format']], 'status' => false, 'message' => ''], 422);
            }
            DB::transaction(function () use ($owner_id, $datas) {
                
                $chartofaccount = Chartofaccount::where('user_id', $owner_id)->first();
                if (!$chartofaccount) {
                    DB::table('chartofaccounts')->insert($datas);
                }else{
                    foreach ($datas as $key => $data) { // 
                        $account = Chartofaccount::where(function($q) use($owner_id, $data){
                            $q->where('user_id', $owner_id)
                                ->where('name', $data['name'])
                                ->where('code', $data['code'])
                                ->where('type', $data['type']);
                        })->first();
                        if ($account) { //ifaccount found thn update
                            $account->update([
                                    'name' =>  $data['name'], 
                                    'code' =>  $data['code'],
                                    'type' =>  $data['type']
                                ]);
                        }else{ 
                            $createData = [
                                'name'       => $data['name'], 
                                'code'       => $data['code'],
                                'type'       => $data['type'],
                                'user_id'    => $owner_id,
                                'isActive'   => 1,
                            ];
                            Chartofaccount::create($createData);
                        }
                    }
                }
                return true;
            });
            $chartofaccounts = Chartofaccount::where('user_id', $owner_id)->latest()->paginate(config('app.pagination'));
            \Storage::disk('local')->delete($file_name);
            return new ChartofaccountCollection($chartofaccounts);
        } catch (\Exception $e) {
            Log::error($e);
            return response(['message' =>  "format invalid or file format not accepted", 'status' => false], 500);
        }
    }