<?php
class MY_Loader extends CI_Loader {
    public function template($template_name, $vars = array(), $return = FALSE)
    {
        $content  = $this->view('includes/header', $vars, $return);
        $content .= $this->view('includes/log_header', $vars, $return);
        $content .= $this->view('includes/leftmenu', $vars, $return);
        $content .= $this->view($template_name, $vars, $return);
        $content .= $this->view('includes/footer', $vars, $return);

        if ($return)
        {
            return $content;
        }
    }
}