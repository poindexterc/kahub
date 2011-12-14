<?php 
class RequestQueries
{
	function GetStoryID()
	{
		if(isset($_GET['storyid']))
		{
			return $_GET['storyid'];
		}
		else
		{
			return 0;
		}
	}
	
		
	function GetSearchQuery()
	{
		if(isset($_GET['q']))
		{
			return $_GET['q'];
		}
		else
		{
			return false;
		}
	}
	
	function GetSearchType()
	{
		if(isset($_GET['st']) && $_GET['st'] != "")
		{
			return $_GET['st'];
		}
		else
		{
			return "bestmatch";
		}
	}
	
	function GetTagQuery()
	{
		if(isset($_GET['tag']))
		{
			return $_GET['tag'];
		}
		else
		{
			return false;
		}
	}
	
	function GetRegion()
	{
		$result = false;
		if(isset($_GET['region']))
		{
			$result = $_GET['region'];
			if($result == "all")
			{
				$result = false;
			}				
		}
		return $result;
	}
	
	function GetCategory()
	{
		$result = 0;
		if(isset($_GET['category']))
		{
			$result = $_GET['category'];							
		}
		return $result;
	}
    
    function GetChannel()
    {
        $result = 0;
        if(isset($_GET['channel']))
        {
            $result = $_GET['channel'];                            
        }
        return $result;
    }
	
	function GetSocialMediaType()
	{
		$result = "7";
		if(isset($_GET['sm']) && strlen($_GET['sm']) > 0)
		{
			$result = $_GET['sm'];											
		}
		
		return $result;
	}
	
	
	function GetTimeSpan()
	{
		$result = "recent";
		if(isset($_GET['ts']) && strlen($_GET['ts']) > 0)
		{
			$result = $_GET['ts'];											
		}				
		return $result;
	}
	
	function GetType()
	{
		$result = "popular";
		if(isset($_GET['type']) && strlen($_GET['type']) > 0)
		{
			$result = $_GET['type'];											
		}				
		return $result;
	}
    
    function GetUserName()
    {
        $result = "";
        if(isset($_GET['un']) && strlen($_GET['un']) > 0)
        {
            $result = $_GET['un'];
        }
        return $result;
    }
    
    function GetSourceURLRequested()
    {
		$result = "www.sopider.com";
		if(isset($_GET['url']) && strlen($_GET['url']) > 0)
		{
			$result = $_GET['url'];
		}
		return $result;
	}

}
?>