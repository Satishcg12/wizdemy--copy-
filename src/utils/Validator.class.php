<?php
class Validator
{
    public static function validate($request, $rules)
    {
        $errors = [];

        foreach ($rules as $key => $rule) {
            // $key = 'name'
            // $rule = ['required', 'min:3', 'max:255']
            foreach ($rule as $r) {
                // $r = 'required'
                // $r = 'min:3'
                // $r = 'max:255'
                $r = explode(':', $r);
                // $r = ['required']
                // $r = ['min', '3']
                // $r = ['max', '255']
                switch ($r[0]) {
                    case 'required':
                        if (!isset($request[$key]) || empty($request[$key])) {
                            $errors[] = 'The ' . $key . ' field is required';
                        }
                        break;
                    case 'min':
                        if (isset($request[$key]) && strlen($request[$key]) < $r[1]) {
                            $errors[] = 'The ' . $key . ' field must be at least ' . $r[1] . ' characters';
                        }
                        break;
                    case 'max':
                        if (isset($request[$key]) && strlen($request[$key]) > $r[1]) {
                            $errors[] = 'The ' . $key . ' field must be at most ' . $r[1] . ' characters';
                        }
                        break;
                    case 'email':
                        if (isset($request[$key]) && !filter_var($request[$key], FILTER_VALIDATE_EMAIL)) {
                            $errors[] = 'The ' . $key . ' field must be a valid email';
                        }
                        break;
                    case 'unique':
                        if (isset($request[$key])) {
                            $model = new $r[1]();
                            if ($model->exists($key, $request[$key])) {
                                $errors[] = 'The ' . $key . ' field already exists';
                            }
                        }
                        break;
                    case 'image':
                        if (isset($request[$key])) {
                            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                            $ext = pathinfo($request[$key]['name'], PATHINFO_EXTENSION);
                            if (!in_array($ext, $allowed)) {
                                $errors[] = 'The ' . $key . ' field must be an image';
                            }
                        }
                        break;
                    case 'file':
                        if (isset($request[$key])) {
                            $allowed = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx'];
                            $ext = pathinfo($request[$key]['name'], PATHINFO_EXTENSION);
                            if (!in_array($ext, $allowed)) {
                                $errors[] = 'The ' . $key . ' field must be a file';
                            }
                        }
                        break;
                    case 'size':
                        if (isset($request[$key])) {
                            $size = $request[$key]['size'];
                            if ($size > 1000000) {
                                $errors[] = 'The ' . $key . ' field must be at most 1 MB';
                            }
                        }
                        break;
                    case 'max-size':
                        if (isset($request[$key])) {
                            $size = $request[$key]['size'];
                            if ($size > $r[1]) {
                                $errors[] = 'The ' . $key . ' field must be at most ' . $r[1] . ' KB';
                            }
                        }
                        break;
                    case 'min-size':
                        if (isset($request[$key])) {
                            $size = $r[1];
                            if ($size < 1000) {
                                $errors[] = 'The ' . $key . ' field must be at least ' . $size . ' KB';
                            }
                        }
                        break;
                    case 'confirmed':
                        if (isset($request[$key]) && $request[$key] !== $request[$key . '_confirmation']) {
                            $errors[] = 'The ' . $key . ' field does not match';
                        }
                        break;
                    case 'password':
                        if (isset($request[$key])) {
                            if (!preg_match('/[A-Z]/', $request[$key])) {
                                $errors[] = 'The ' . $key . ' field must contain at least one uppercase letter';
                            }
                            if (strlen($request[$key]) < 8) {
                                $errors[] = 'The ' . $key . ' field must be at least 8 characters';
                            }
                        }
                        break;
                }
            }
        }
        if (count($errors) > 0) {
            //msg = 'The name field is required'
            return ['status' => false, 'msg' => $errors];
        } else {
            return ['status' => true];
        }
    }



}
