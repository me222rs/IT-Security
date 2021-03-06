<?php
	require_once("common/HTMLView.php");
	require_once("LoginController.php");
	require_once("LoginModel.php");
	require_once("LoginView.php");
	require_once("ForumView.php");
	
	class MasterController{
		private $model;
		private $view;
		private $forumView;
			
		public function __construct(){
			$userAgent = $_SERVER['HTTP_USER_AGENT'];
						
			// Skapar nya instanser av modell- & vy-klassen och l�gger dessa i privata variabler.
			$this->model = new LoginModel($userAgent);
			$this->view = new LoginView($this->model);
			$this->forumView = new ForumView($this->model);

			
			echo "Kommer in i MasterController";
			var_dump($this->view->didUserPressLogin());
			//V�ljer vilken controller som ska anv�ndas beroende p� indata, t.ex. knappar och l�nkar.
			if(!$this->view->didUserPressLogin() && !$this->forumView->didUserPressCreateNewTopic() && !$this->forumView->didUserPressTopic())
			{
				echo "Kommer in i if";
				$loginC = new LoginController();
				$htmlBodyLogin = $loginC->doHTMLBody();
			}
			//Trycker på Show topics
			elseif($this->forumView->didUserPressTopic()){
				var_dump("Login status = " . $this->model->checkLoginStatus());
				echo "Tryckt på visa alla ämnen";
				$loginC = new LoginController();
				$htmlBodyLogin = $loginC->doShowTopic();
				
			}
			//Trycker på Create new topic
			elseif($this->forumView->didUserPressCreateNewTopic()){
				echo "Tryckt på skapa nytt ämne";
				$loginC = new LoginController();
				$htmlBodyLogin = $loginC->doCreateNewTopic();
				
			}
			

			
			else{
				echo "Kommer in i else";
				$loginControl = new LoginController();
				$htmlBodyLogin = $loginControl->doHTMLBody();
			}
			
			
			
		}
	}