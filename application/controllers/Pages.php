<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function view($page = 'home')
	{
		if(!file_exists(APPPATH. 'views/pages/'.$page.'.php')){
                show_404();
        }
        else{                
                $data['title'] = $page;
                switch($page){
                        case 'home':    
                                $data['resultArray'] = $this->product->getData();
                                $data['getProduct'] = $this->product->getProduct();
                                $this->load->view('templates/header', $data);
                                $this->load->view('templates/_banner-area', $data);
                                $this->load->view('templates/_top-sale', $data);
                              /*   $this->load->view('templates/_special-price', $data);
                                $this->load->view('templates/_banner-ads', $data);
                              */  $this->load->view('templates/_new-phones', $data);
                               /* $this->load->view('templates/_blogs', $data); */
                                $this->load->view('pages/'.$page, $data);
                                $this->load->view('templates/footer', $data);
                        break;

                        case 'cart':
                                $data['resultArray'] = $this->product->getData();
                                $data['getProduct'] = $this->product->getProduct();
                                $this->load->view('templates/header', $data);

                                /*  include cart items if it is not empty */
                                count($this->product->getData('cart')) ? $this->load->view('templates/_cart-template') :  $this->load->view('templates/notFound/_cart_notFound');
                                /*  include cart items if it is not empty */

                                   count($this->product->getData('wishlist')) ? $this->load->view('templates/_wishilist_template') :  $this->load->view('templates/notFound/_wishlist_notFound');
                                $this->load->view('templates/_new-phones', $data);
                                $this->load->view('templates/footer', $data);
                        break;

                }
        }
	}
}
