<?php
class User {
	private $user_id;
	private $user_name;
	private $user_pass;
	private $user_email;
	private $user_country;
	private $user_gender;
	private $user_b_day;
	private $user_image;
	static public $user = null;
	static public $loggedIn = false;

	function __construct($data)
	{
		$this->user_id = $data['user_id'];
		$this->user_name = $data['user_name'];
		$this->user_pass = $data['user_pass'];
		$this->user_email = $data['user_email'];
		$this->user_country = $data['user_country'];
		$this->user_gender = $data['user_gender'];
		$this->user_b_day = $data['user_b_day'];
		$this->user_image = $data['user_image'];
	}
	
	static public function getCurrent()
	{
		return self::$user;
	}
	
	static public function isLoggedIn()
	{
		return self::$loggedIn;
	}
	
	static public function autoLogin($con)
	{
		if (isset($_SESSION['user_email']))
		{
			$user_email = $_SESSION['user_email'];
			$query = mysqli_query($con, "SELECT * FROM users WHERE user_email='{$user_email}' LIMIT 1");
			if ($data = mysqli_fetch_array($query)) 
			{
				self::$loggedIn = true;
				self::$user = new User($data);
			}
		}
	}
	
	static public function constructFromUserId($con, $user_id)
	{
		$query = mysqli_query($con, "SELECT * FROM users WHERE user_id='{$user_id}' LIMIT 1");
			if ($data = mysqli_fetch_array($query)) 
				return new User($data);
	}
	
	public function logout()
    {
		unset($_SESSION['user_email']);
		self::$loggedIn = false;
		self::$user = null;
	}
	
	public function messageUser($con, $user_id, $message)
	{
		$query = mysqli_query($con, "INSERT INTO users_chat (user_id1, user_id2, message) VALUE ('".$this->getId()."', '".$user_id."', '".addslashes($message)."')");
		
		if ($query)
			return true;
	}
	
	public function getChatWithUser($con, $user_id)
	{
		$query = mysqli_query($con, "SELECT * FROM users_chat WHERE (user_id1 = '".$this->getId()."' AND user_id2 = '".$user_id."') OR (user_id1 = '".$user_id."' AND user_id2 = '".$this->getId()."') ORDER BY id DESC LIMIT 10");
		
		$chatData = array();
		while ($row = mysqli_fetch_array($query))
		{
			$chatData[] = $row;
		}
		
		return $chatData;
	}
	
	public function isFriendRequestedFromUser($con, $user_id)
	{
		$query = mysqli_query($con, "SELECT * FROM users_friends WHERE status='pending' AND user_id1 = '".$user_id."' AND user_id2 = '".$this->getId()."'");
		if (mysqli_num_rows($query) == 0)
			return false;
		else
			return true;
	}
	
	public function isFriendRequestedWith($con, $user_id)
	{
		$query = mysqli_query($con, "SELECT * FROM users_friends WHERE (status='pending' AND user_id1 = '".$this->getId()."' AND user_id2 = '".$user_id."') OR (status='pending' AND user_id1 = '".$user_id."' AND user_id2 = '".$this->getId()."')");
		if (mysqli_num_rows($query) == 0)
			return false;
		else
			return true;
	}
	
	public function isFriendsWith($con, $user_id)
	{
		$query = mysqli_query($con, "SELECT * FROM users_friends WHERE (status='done' AND user_id1 = '".$this->getId()."' AND user_id2 = '".$user_id."') OR (status='done' AND user_id1 = '".$user_id."' AND user_id2 = '".$this->getId()."')");
		if (mysqli_num_rows($query) == 0)
			return false;
		else
			return true;
	}
	
	public function addFriendRequest($con, $user_id)
	{
		if (!$this->isFriendRequestedWith($con, $user_id) && !$this->isFriendsWith($con, $user_id))
			mysqli_query($con, "INSERT INTO users_friends (status, user_id1, user_id2) VALUE ('pending', '{$this->user_id}', '{$user_id}')");
	}
	
	public function addFriend($con, $user_id)
	{
		if ($this->isFriendRequestedWith($con, $user_id))
			mysqli_query($con, "UPDATE users_friends SET status='done' WHERE (status='pending' AND user_id1 = '".$this->getId()."' AND user_id2 = '".$user_id."') OR (status='pending' AND user_id1 = '".$user_id."' AND user_id2 = '".$this->getId()."')");
	    else
			$this->addFriendRequest($con, $user_id);
	}
	
	public function rejectFriendRequest($con, $user_id)
	{
		mysqli_query($con, "DELETE FROM users_friends WHERE (user_id1 = '".$this->getId()."' AND user_id2 = '".$user_id."') OR (user_id1 = '".$user_id."' AND user_id2 = '".$this->getId()."')");
	}
	
	public function removeFriend($con, $user_id)
	{
			mysqli_query($con, "DELETE FROM users_friends WHERE (user_id1 = '".$this->getId()."' AND user_id2 = '".$user_id."') OR (user_id1 = '".$user_id."' AND user_id2 = '".$this->getId()."')");
	}
	
	public function updateImage($con, $newImage)
	{
		mysqli_query($con, "UPDATE users SET user_image='".$newImage."' WHERE user_id='".$this->getId()."'");
	}
	
	public function getId()
	{
		return $this->user_id;
	}
	
	public function getUsername()
	{
		return $this->user_name;
	}
	
	public function getImage()
	{
		return $this->user_image;
	}
	
	public function getEmail()
	{
		return $this->user_email;
	}
	
	public function getCountry()
	{
		return $this->user_country;
	}
}
?>