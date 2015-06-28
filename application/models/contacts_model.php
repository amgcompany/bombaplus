<?php
	class Contacts_model extends CI_Model 
	{
		public function __construct() {
			parent::__construct();
		}
		public function send_email() 
		{
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('namef', 'Име и фамилия', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Е-майл', 'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules('subject', 'Тема', 'trim|required|xss_clean');
			$this->form_validation->set_rules('message', 'Съобщение', 'trim|required|xss_clean');
			
			if($this->form_validation->run() == FALSE) 
			{
				return 'doesnt_run';
			} else {
				$email 		= $this->input->post('email');
				$subject 	= $this->input->post('subject');
				$namef 		= $this->input->post('namef');
				$message 	= $this->input->post('message');
				
				$this->load->library('email');

				$this->email->from($email, $namef);
				$this->email->to('contact@bombaplus.com'); 

				$this->email->subject($subject);
				$this->email->message($message);	

				$this->email->send();
			}
		}
	}