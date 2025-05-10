<?php

namespace App\Service; 

class   FileService{
    public function uploadPhoto($data){
        $file = $data['image'];
        $filename = time(). "_" . $file->getClientOriginalName();
        $file_path = $file->storeAs('photos', $filename, 'public');

        return str_replace('public/', '', $file_path);
    }

    public function uploadPdf($data){
        $file = $data['pdf'];
        $filename = time() . "_" . $file->getClientOriginalName();
        $file_path = $file->storeAs('syllabus', $filename, 'public');

        return str_replace('public/', '', $file_path);
    }
}