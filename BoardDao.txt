<?php
class BoardDao {
	private $db;
	
	public function __construct() {
		try {
			$this->db = new PDO("mysql:host=locathost;dbname=phpdb", "php", "1234");
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			exit($e->getMessage());
		}
	}
	
	public function getNumMsgs() {
		try {
			$query = $this->db->prepare("select count(*) from board");
			$query->execute();
			
			$numMsgs = $query->fetchColumn();
			
		} catch (PDOException $e) {
			exit($e->getMessage());
		}
		
		return $numMsgs;
	}
	
	public function getMsg($num) {
		try {
			$query = $this->db->prepare("selet * from board where num=:num");
			$query->bindValue(":num", $num, PDO::PARAM_INT);
			$query->execute();
			
			$msg = $query->fetch(PDO::FETCH_ASSOC);
			
		} catch (PDOException $e) {
			exit($e->getMessage());
		}
		
		return $msg;
	}
	
	public function getManyMsgs($start, $rows) {
		try {
			$query = $this->db->prepare("select * from board order by num desc limit :start, :rows");
			$query->bindValue(":start", $start, PDO::PARAM_INT);
			$query->bindValue(":rows", $rows, PDO::PARAM_INT);
			$query->execute();
			
			$msgs = $query->fetchAll(PDO::FETCH_ASSOC);
			
		} catch (PDOException $e) {
			exit($e->getMessage());
		}
		
		return $msgs;
	}
	
	public function insertMsg($writer, $title, $content) {
		try {
			$query = $this->db->prepare("insert into board (writer, title, content, regtime, hits) values (:writer, :title, :content, :regtime, 0)");
			
			$regtime = date("Y-m-d H:i:s");
			$query->bindValue(":writer", $writer, PDO::PARAM_STR);
			$query->bindValue(":title", $title, PDO::PARAM_STR);
			$query->bindValue(":content", $content, PDO::PARAM_STR);
			$query->bindValue(":regtime", $regtime, PDO::PARAM_STR);
			$query->execute();
			
		} catch (PDOException $e) {
			exit($e->getMessage());
		}
	}
	
	public function updateMsg($num, $writer, $title, $content) {
		try {
			$query = $this->db->prepare("update board set writer=:writer, title=:title, content=:content, regtime=:regtime where num=:num");
			
			$regtime = date("Y-m-d H:i:s");
			$query->bindValue(":writer", $writer, PDO::PARAM_STR);
			$query->bindValue(":title", $title, PDO::PARAM_STR);
			$query->bindValue(":content", $content, PDO::PARAM_STR);
			$query->bindValue(":regtime", $regtime, PDO::PARAM_STR);
			$query->bindValue(":num", $num, PDO::PARAM_INT);
			$query->execute();
			
		} catch (PDOException $e) {
			exit($e->getMessage());
		}
	}
	
	public function deleteMsg($num) {
		try {
			$query = $this->db->prepare("delete from board where num=:num");
			$query->bindValue(":num", $num, PDO::PARAM_INT);
			$query->execute();
			
		} catch(PDOException $e) {
			exit($e->getMessage());
		}
	}
	
	public function increaseHits($num) {
		try {
			$query = $this->db->prepare("update board set hits=hits+1 where num=:num");
			$query->bindValue(":num", $num, PDO::PARAM_INT);
			$query->execute();
			
		} catch (PDOException $e) {
			exit($e->getMessage());
		}
	}
}
?>