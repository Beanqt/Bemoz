<?php namespace App\Http\Controllers\Slim;

use Illuminate\Support\Str;

class Slim {
    public $image = '';
    public $saved = '';
    public $name = '';

    public function __construct($inputName = 'slim', $post = true){
        $this->image = '';
        $this->saved = '';
        $this->getImages($inputName, $post);
    }

    public function getImages($inputName = 'slim', $post = true) {
        if($post) {
            $value = $this->getPostData($inputName);
        }else{
            $value = $inputName;
        }

        if($value === false || empty($value)) {
            return false;
        }

        $this->image = $this->parseInput($value);

        return $this->image;
    }

    public function hasImage(){
        if(empty($this->image)){
            return false;
        }
        return true;
    }

    public function save($path, $cropped_name = 'small'){
        $uid = microtime(true);
        $this->saved = $this->saveFile($this->image['input']['data'], $this->image['input']['name'], 'uploads/'.$path.'/', $uid);
        $this->saveFile($this->image['output']['data'], $cropped_name.'-'.$this->image['input']['name'], 'uploads/'.$path.'/', $uid);
    }

    public function getName(){
        return $this->saved['name'];
    }

    public function getCrop($with_size = false){
        $array = ['crop' => $this->image['actions']['crop']['x'].','.$this->image['actions']['crop']['y'].','.$this->image['actions']['crop']['width'].','.$this->image['actions']['crop']['height']];
        if($with_size){
            $array['size'] = $this->image['actions']['size'];
        }
        return json_encode($array);
    }

    public function remove($path, $image, $cropped_name = 'small'){
        if(file_exists(public_path('uploads/'.$path.'/'.$image))){
            unlink(public_path('uploads/'.$path.'/'.$image));
        }
        if(file_exists(public_path('uploads/'.$path.'/'.$cropped_name.'-'.$image))){
            unlink(public_path('uploads/'.$path.'/'.$cropped_name.'-'.$image));
        }
    }

    private function parseInput($value) {
        if (empty($value)) {return null;}

        $data = json_decode($value);

        $input = null;
        $actions = null;
        $output = null;
        $meta = null;

        if (isset ($data->input)) {
            $inputData = isset($data->input->image) ? $this->getBase64Data($data->input->image) : null;
            $input = array(
                'data' => $inputData,
                'name' => $data->input->name,
                'type' => $data->input->type,
                'size' => $data->input->size,
                'width' => $data->input->width,
                'height' => $data->input->height,
            );
        }

        if (isset($data->output)) {
            $outputData = isset($data->output->image) ? $this->getBase64Data($data->output->image) : null;
            $output = array(
                'data' => $outputData,
                'width' => $data->output->width,
                'height' => $data->output->height
            );
        }

        if (isset($data->actions)) {
            $actions = array(
                'crop' => $data->actions->crop ? array(
                    'x' => $data->actions->crop->x,
                    'y' => $data->actions->crop->y,
                    'width' => $data->actions->crop->width,
                    'height' => $data->actions->crop->height,
                    'type' => $data->actions->crop->type
                ) : null,
                'size' => $data->actions->size ? array(
                    'width' => $data->actions->size->width,
                    'height' => $data->actions->size->height
                ) : null
            );
        }

        if (isset($data->meta)) {
            $meta = $data->meta;
        }

        return array(
            'input' => $input,
            'output' => $output,
            'actions' => $actions,
            'meta' => $meta
        );
    }

    public function saveFile($data, $name, $path = 'tmp/', $uid = false) {
        if (substr($path, -1) !== '/') {
            $path .= '/';
        }

        if(!is_dir($path)){
            mkdir($path, 0755, true);
        }

        $array = explode('.',$name);
        $ext = end($array);
        $name_path = Str::slug(str_replace('.'.$ext, '', $name));

        if ($uid) {
            preg_match_all("/-+[0-9]{6,14}/",str_replace(['small-','slider-','bg-'],['','',''],$name_path),$matches);

            foreach($matches[0] as $match){
                $name_path = str_replace($match,'',$name_path);
            }

            $name_path = $name_path .'-'. str_replace('.','',$uid);
        }
        $name = $name_path;

        $path = $path . $name.'.'.$ext;

        $this->saveImage($data, $path);

        return array(
            'name' => $name.'.'.$ext,
            'path' => $path
        );
    }

    public function outputJSON($data) {
        header('Content-Type: application/json');

        echo json_encode($data);
    }

    private function getPostData($inputName) {
        $values = array();

        if(isset($_POST[$inputName])) {
            $values = $_POST[$inputName];
        }elseif(isset($_FILES[$inputName])) {
            return false;
        }

        return $values;
    }

    /**
     * Saves the data to a given location
     * @param $data
     * @param $path
     */
    private function saveImage($data, $path) {
        file_put_contents($path, $data);
    }

    /**
     * Strips the "data:image..." part of the base64 data string so PHP can save the string as a file
     * @param $data
     * @return string
     */
    private function getBase64Data($data) {
        return base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
    }

}