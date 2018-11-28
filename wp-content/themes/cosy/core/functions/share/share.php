<?php

/*
            /$$            
    /$$    /$$$$            
   | $$   |_  $$    /$$$$$$$
 /$$$$$$$$  | $$   /$$_____/
|__  $$__/  | $$  |  $$$$$$ 
   | $$     | $$   \____  $$
   |__/    /$$$$$$ /$$$$$$$/
          |______/|_______/ 
================================
        Keep calm and get rich.
                    Is the best.

  	@Author: Dami
  	@Date:   2017-09-16 11:36:51
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-09-16 14:45:03

*/


class MiShare {

	//private $config;

	private $config;

	function __construct(){

		$this->config = array(
			'url'   => get_permalink(),
			'title' => get_the_title(),
			'pic'   => null,
			'des'   => null,
		);

	}

	function __set($property,$value){ 
    	$this->$property = $value; 
    }

    /**
     * [weibo Share]
     * @return [str] [ Share api link]
     */
	public function weibo() {

		$pic = isset($this->config['pic']) ? '&pic='.urlencode( $this->config['pic'] ) : '';

		if( isset( $this->config['des'] ) ){
			$text = urlencode( sprintf( '【%s】%s', $this->config['title'], $this->config['des']) );
		}else{
			$text = $this->config['title'];
		}

		$share_link = sprintf( 'https://service.weibo.com/share/share.php?url=%s&type=button&language=zh_cn&title=%s%s&searchPic=true', urlencode( $this->config['url'] ), $text , $pic );

		return $share_link;
		
	}

	/**
	 * [qq Share]
	 * @return [str] [ Share api link]
	 */
	public function qq() {

		$pic = isset($this->config['pic']) ? '&pics='.urlencode( $this->config['pic'] ) : '';

		$des = isset($this->config['des']) ? '&summary='.$this->config['des'] : '';
		
		$share_link = sprintf( 'https://connect.qq.com/widget/shareqq/index.html?url=%s&title=%s%s%s', urlencode( $this->config['url'] ), $this->config['title'], $pic, $des );

		return $share_link;


	}

	/**
	 * [weixin Share]
	 * @return [str] [Share qrcode link]
	 */
	public function weixin() {

		$share_link = get_template_directory_uri() . '/core/functions/share/qrcode.php?data='.urlencode( $this->config['url'] );

		return $share_link;		

	}

}
// $s = new MiShare();
// $s->config = array( 'url' => 'https://www.baidu.com', 'title' => '标题', 'pic' => 'https://cdn.v2ex.com/gravatar/afa39accf8700cbbe7b13e1d01aa5b17', 'des' => '123');

// echo $s->weixin();

