<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use App\Models\User;
    use App\Traits\ApiResponser;
    use DB;

    Class UserController extends Controller {
        use ApiResponser;

        private $request;

        public function __construct(Request $request){
            $this->request = $request;
        }

        public function getUsers(){
            //$users = User::all();
            $users = DB::connection('mysql')
            ->select("Select * from tbluser");

            //return response()->json($users, 200);
            return $this->successResponse($users);
        }

        public function index(){
            $users = User::all();
            return $this->successResponse($users);
        }

        public function addUser(Request $request) {
            $rules = [
                'username' => 'required|max:20',
                'password' => 'required|max:20',
            ];
            
            $this->validate($request, $rules);
            $user = User::create($request->all());
            return $this->successResponse($user, Response::HTTP_CREATED);
        }

        public function show($id) {

            $users = User::findOrFail($id);
            return $this->successResponse($users);       

            //old code
            /*
            $users = User::where('id', $id)->first();
            if ($users){
                return $this->successResponse($users);
            }
            return $this->errorResponse('User ID Does Not Exist', Response::HTTP_NOT_FOUND);*/
        }
        public function update(Request $request, $id) {
            $rules = [
                'username' => 'max:20',
                'password' => 'max:20',
                //'admin' => 'in:1,0',
            ];

            $this->validate($request, $rules);
            $users = User::findOrFail($id);

            $users->fill($request->all());

            //if no changes happen
            if ($users->isClean()){
                return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $users->save();
            return $this->successResponse($users);

            
            //old code
            /*
            $users = User::where('id', $id)->first();

                if($users){
                    $users->fill($request->all());
                    if($users->isClean()) {
                        return $this->errorResponse('At least one value must be changed',
                        Response::HTTP_UNPROCESSABLE_ENTITY);
                    }
                    $users->save();
                    return $this->successResponse($users);
                }
                return $this->errorResponse('User ID does not exist', Response::HTTP_NOT_FOUND);*/
        }

        public function delete($id) {

            $users = User::findOrFail($id);
            $users->delete();
            return $this->errorResponse('User ID Does Not Exist', Response::HTTP_NOT_FOUND);
            //old code
            /*
            $users = User::where('id', $id)->first();
            if($users){
                $users->delete();
                return $this->successResponse($users);
            }
            return $this->errorResponse('User ID does not exist', Response::HTTP_NOT_FOUND);*/
        }
    }

?>