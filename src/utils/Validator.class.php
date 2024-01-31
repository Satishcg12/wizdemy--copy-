<?php
class Validator{
    public static function make($request, $rules){
        // $request = [
        //     'name' => 'John Doe',
        //     'image' => 'image.jpg',
        //      'file' => 'file.pdf',
        //     'email' => 'john@example',
        //     'username' => 'johndoe',
        //     'password' => '123456',
        //     'password_confirmation' => '123456'
        // ];
        // $rules = [
        //     'name' => ['required', 'min:3', 'max:255'],
        //     'image' => ['required', 'image', 'size:1000'],
        //     'file' => ['required', 'file:pdf', 'size:1000'],
        //     'username' => ['required', 'min:3', 'max:255', 'unique:users'],
        //     'email' => ['required', 'email', 'unique:users'],
        //     'password' => ['required', 'min:6', 'confirmed','password'],
        // ];
        
        $errors = [];

        foreach($rules as $key => $rule){
            // $key = 'name'
            // $rule = ['required', 'min:3', 'max:255']
            foreach($rule as $r){
                // $r = 'required'
                // $r = 'min:3'
                // $r = 'max:255'
                $r = explode(':', $r);
                // $r = ['required']
                // $r = ['min', '3']
                // $r = ['max', '255']
                switch($r[0]){
                    case 'required':
                        if(!isset($request[$key]) || empty($request[$key])){
                            $errors[$key][] = 'The '.$key.' field is required';
                        }
                        break;
                    case 'min':
                        if(isset($request[$key]) && strlen($request[$key]) < $r[1]){
                            $errors[$key][] = 'The '.$key.' field must be at least '.$r[1].' characters';
                        }
                        break;
                    case 'max':
                        if(isset($request[$key]) && strlen($request[$key]) > $r[1]){
                            $errors[$key][] = 'The '.$key.' field must be at most '.$r[1].' characters';
                        }
                        break;
                    case 'email':
                        if(isset($request[$key]) && !filter_var($request[$key], FILTER_VALIDATE_EMAIL)){
                            $errors[$key][] = 'The '.$key.' field must be a valid email';
                        }
                        break;
                    case 'unique':
                        if(isset($request[$key])){
                            $model = new $r[1]();
                            if($model->exists($key, $request[$key])){
                                $errors[$key][] = 'The '.$key.' field already exists';
                            }
                        }
                        break;
                    case 'image':
                        if(isset($request[$key])){
                            $allowed = ['jpg', 'jpeg', 'png'];
                            $ext = pathinfo($request[$key], PATHINFO_EXTENSION);
                            if(!in_array($ext, $allowed)){
                                $errors[$key][] = 'The '.$key.' field must be an image';
                            }
                        }
                        break;
                    case 'file':
                        if(isset($request[$key])){
                            // $r[1] = 'pdf'
                            
                            $allowed = [$r[1]] ?? ['pdf', 'doc', 'docx'];
                            $ext = pathinfo($request[$key], PATHINFO_EXTENSION);
                            if(!in_array($ext, $allowed)){
                                $errors[$key][] = 'The '.$key.' field must be a file';
                            }
                        }
                        break;
                    case 'size':
                        if(isset($request[$key])){
                            $size = $r[1];
                            if($size < 1000){
                                $errors[$key][] = 'The '.$key.' field must be at least '.$size.' KB';
                            }
                        }
                        break;
                    case 'confirmed':
                        if(isset($request[$key]) && $request[$key] !== $request[$key.'_confirmation']){
                            $errors[$key][] = 'The '.$key.' field does not match';
                        }
                        break;
                    case 'password':
                        if(isset($request[$key])){
                            if(!preg_match('/[A-Z]/', $request[$key])){
                                $errors[$key][] = 'The '.$key.' field must contain at least one uppercase letter';
                            }
                            if(strlen($request[$key]) < 8){
                                $errors[$key][] = 'The '.$key.' field must be at least 8 characters';
                            }
                        }
                        break;
                }
            }
        }
        return $errors;
    }
}
