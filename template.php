<?php
/**
 * Created by PhpStorm.
 * User: menakafernando
 * Date: 7/12/18
 * Time: 10:29 AM
 */

class  Template {
    private $vars = array();
    public $path;
    public $content;
    private $valid = false;
    public  $stack = array();
    public $final;

    function __construct($template_name) {
        $this->path = $template_name . '.tmpl';

        if (file_exists($this->path)){
            $this->content = file_get_contents($this->path);
            $this->valid = true;
        } else{
            exit('<h3>Template Error!!</h3>');
        }

    }

    public function replace($str) {
        if (isset($this->vars[$str])) {
            echo $this->vars[$str];
        } else {
            echo '{{' . $str . '}}';
        }
    }

    public function wrap($arr, $main_arr, $count) {
        $this->stack[] = $this->vars;

        if ($count == sizeof($main_arr)) {
            $this->final = true;
        }else{
            $this->final = false;

        }


        foreach ($arr as $k => $v) {
            $this->vars[$k] = $v;
        }
    }


    public function lastElem($con) {
        if($con == '@last') {
            if($this->final){
                return false;
            }

            return true;
        }
        return false;
    }

    public function unwrap() {
        $this->vars = array_pop($this->stack);
    }

    public function render() {
        if($this->valid){
            $this->content = preg_replace('/\{\{#unless (@\w+)\}\}/', '<?php if ($this->lastElem(\'$1\')):  ?>', $this->content);
            $this->content = preg_replace('/\{\{else\}\}/', '<?php else :  ?>', $this->content);
            $this->content = preg_replace('/\{\{\/unless\}\}/', '<?php endif; ?>', $this->content);

            $this->content  = preg_replace('/[\n\r]/','<br>', $this->content );
            $this->content = preg_replace('/\{\{(\w+)\}\}/', '<?php $this->replace(\'$1\'); ?>', $this->content);
            $this->content = preg_replace('/\{\{#each (\w+)\}\}/', '<?php $loop = $this->vars[\'$1\'];$count = 0; foreach ($this->vars[\'$1\'] as $arr): $count++; $this->wrap($arr, $loop, $count); ?>', $this->content);
            $this->content = preg_replace('/\{\{\/each\}\}/', '<?php $this->unwrap(); endforeach; ?>', $this->content);

            eval(' ?> '. $this->content .' <?php ');
        }
    }

    public function assign($key, $value) {
        $this->vars[$key] = $value;
    }

}