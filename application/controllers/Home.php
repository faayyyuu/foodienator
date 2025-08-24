<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function index()
	{
		$this->load->model('Menu_model');
		$dish = $this->Menu_model->getMenu();
		$data['dishesh'] = $dish;
		$this->load->view('front/partials/header');
		$this->load->view('front/home', $data);
		$this->load->view('front/partials/footer');
	}

	public function sendMail() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name', 'trim|required');
		$this->form_validation->set_rules('email','Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('subject','Subject', 'trim|required');
		$this->form_validation->set_rules('message','Message', 'trim|required');

		if($this->form_validation->run() == true) {
			$name 		= $this->input->post('name');
			$emailFrom 	= $this->input->post('email');
			$subject 	= $this->input->post('subject');
			$message 	= $this->input->post('message');

			// ✅ Configure Gmail SMTP
			$config = array(
				'protocol'  => 'smtp',
				'smtp_host' => 'smtp.gmail.com',
				'smtp_port' => 587,
				'smtp_user' => 'rehannewrekar@gmail.com', // Your Gmail
				'smtp_pass' => 'tooithbclbrapyei',        // Gmail App Password
				'smtp_crypto' => 'tls',                   // Use TLS
				'mailtype'  => 'html',
				'charset'   => 'utf-8',
				'newline'   => "\r\n",
				'wordwrap'  => TRUE
			);

			$this->load->library('email', $config);

			// ✅ Gmail requires sender = smtp_user
			$this->email->from('rehannewrekar@gmail.com', 'Website Contact');
			$this->email->to('rehannewrekar@gmail.com');

			// add reply-to user email
			$this->email->reply_to($emailFrom, $name);

			$this->email->subject($subject);
			$this->email->message(
				"<b>From:</b> $name ($emailFrom)<br><br>".
				"<b>Message:</b><br>".nl2br($message)
			);

			if ($this->email->send()) {
    $this->session->set_flashdata('msg', 'Mail has been sent successfully.');
    $this->session->set_flashdata('msg_class', 'alert-success');
} else {
    $this->session->set_flashdata('msg', 'Mail is not sent, try again.');
    $this->session->set_flashdata('msg_class', 'alert-danger');
}

redirect('home/index'); // redirect back to contact page

	}
}
}