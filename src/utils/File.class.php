<?php
class File
{
    public static function upload($file, $path)
    {
//if directory does not exist, create it
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'txt'];

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 10000000) {
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $fileDestination = $path . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    return ['status' => true, 'path' => $fileDestination];
                } else {
                    return ['status' => false, 'msg' => 'Your file is too large'];
                }
            } else {
                return ['status' => false, 'msg' => 'There was an error uploading your file'];
            }
        } else {
            return ['status' => false, 'msg' => 'You cannot upload files of this type'];
        }
    }
}