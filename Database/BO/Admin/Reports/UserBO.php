<?php 
class UserBO
{
	var $FreeActiveP;
	var $FreeInActiveP;
	var $PremiumActiveP;
	var $PremiumInActiveP;
	var $FreeActiveC;
	var $FreeInActiveC;
	var $PremiumActiveC;
	var $PremiumInActiveC;
	var $SumFreeP;
	var $SumPrmiumP;
	var $SumFreeC;
	var $SumPrmiumC;
	var $SumP;
	var $SumC;
	
 	function __construct()
 	{
		 		
 	}
	
 	function getFreeActiveP()
 	{
 		return $this->FreeActiveP;
 	}
 	function setFreeActiveP($pFreeActiveP)
 	{
 		$this->FreeActiveP=$pFreeActiveP;
 	}

 	function getFreeInActiveP()
 	{
 		return $this->FreeInActiveP;
 	}
 	function setFreeInActiveP($pFreeInActiveP)
 	{
 		$this->FreeInActiveP=$pFreeInActiveP;
 	}
 	
 	function getPremiumActiveP()
 	{
 		return $this->PremiumActiveP;
 	}
 	function setPremiumActiveP($pPremiumActiveP)
 	{
 		$this->PremiumActiveP=$pPremiumActiveP;
 	}

 	function getPremiumInActiveP()
 	{
 		return $this->PremiumInActiveP;
 	}
 	function setPremiumInActiveP($pPremiumInActiveP)
 	{
 		$this->PremiumInActiveP=$pPremiumInActiveP;
 	}

 	function getFreeActiveC()
 	{
 		return $this->FreeActiveC;
 	}
 	function setFreeActiveC($pFreeActiveC)
 	{
 		$this->FreeActiveC=$pFreeActiveC;
 	}

 	function getFreeInActiveC()
 	{
 		return $this->FreeInActiveC;
 	}
 	function setFreeInActiveC($pFreeInActiveC)
 	{
 		$this->FreeInActiveC=$pFreeInActiveC;
 	}
 	
 	function getPremiumActiveC()
 	{
 		return $this->PremiumActiveC;
 	}
 	function setPremiumActiveC($pPremiumActiveC)
 	{
 		$this->PremiumActiveC=$pPremiumActiveC;
 	}

 	function getPremiumInActiveC()
 	{
 		return $this->PremiumInActiveC;
 	}
 	function setPremiumInActiveC($pPremiumInActiveC)
 	{
 		$this->PremiumInActiveC=$pPremiumInActiveC;
 	}

 	function getSumFreeP()
 	{
 		return $this->SumFreeP;
 	}
 	function setSumFreeP($pSumFreeP)
 	{
 		$this->SumFreeP=$pSumFreeP;
 	}
 	function getSumPremiumP()
 	{
 		return $this->SumPremiumP;
 	}
 	function setSumPremiumP($pSumPremiumP)
 	{
 		$this->SumPremiumP=$pSumPremiumP;
 	}

 	function getSumFreeC()
 	{
 		return $this->SumFreeC;
 	}
 	function setSumFreeC($pSumFreeC)
 	{
 		$this->SumFreeC=$pSumFreeC;
 	}
 	function getSumPremiumC()
 	{
 		return $this->SumPremiumC;
 	}
 	function setSumPremiumC($pSumPremiumC)
 	{
 		$this->SumPremiumC=$pSumPremiumC;
 	}

 	function getSumP()
 	{
 		return $this->SumP;
 	}
 	function setSumP($pSumP)
 	{
 		$this->SumP=$pSumP;
 	}

 	function getSumC()
 	{
 		return $this->SumC;
 	}
 	function setSumC($pSumC)
 	{
 		$this->SumC=$pSumC;
 	}


}


?>