<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends CI_Controller {


    public function __construct()
    {
    	parent::__construct();
    	$this->load->library('session');
    	$this->load->helper('url');
    }
	public function form()
	{
		$this->load->view('login_form');
	}

	public function reg()
	{
		$sesID = '';
		$this->load->model('LoggerModel');

		$email = $this->input->post('email');
		if(!$loginArr = $this->LoggerModel->getInfo($email)){
        $this->form_validation->set_rules('user','User','required');
		$this->form_validation->set_rules('password','Password','required');
		$this->form_validation->set_rules('email','Email','required');
		if($this->form_validation->run()){
		
		$password = $this->input->post('password');
		$cached = md5($password);

		$data = [
            'user' => $this->input->post('user'),
            'password' => $cached,
            'email' => $this->input->post('email')
		];
        $sesID = session_id();
		$this->LoggerModel->insertInfo($data);
		$this->session->set_flashdata('in',$sesID);
		redirect(site_url('AuthController/main'));
        }
		} else {
        redirect(site_url('AuthController/register'));
		}
	}
	public function login()
	{
        $sesID = '';
		$this->load->model('LoggerModel');

        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $cached = md5($password);
		if($this->LoggerModel->getAllInfo($email, $cached)){
 
        $sesID = session_id();
		$this->session->set_flashdata('in',$sesID);
		redirect(site_url('AuthController/main'));
		} else {
        redirect(site_url('AuthController/register'));
		}

	}
	public function main()
	{
		$sesID = $this->session->flashdata('in');
		if($sesID == session_id()){
		$this->load->view('main_page');
	    } else {
        redirect(site_url('AuthController/home'));
	    }

	}
	public function register()
	{
        $this->load->view('register_form');
	}
	public function home()
	{
         $this->load->view('home_page');
	}
}