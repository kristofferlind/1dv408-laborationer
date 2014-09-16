<?php

class AccountDAL {
	private $rememberedAccounts = './data/remembered.accounts.txt';

	public function __construct() {

	}

	public function rememberUser($token, $username, $expirationDate) {
		$this->removeByToken($token);
		$rememberedAccountsFile = fopen($this->rememberedAccounts, 'a');
		fwrite($rememberedAccountsFile, "$token,$username,$expirationDate\n");
		fclose($rememberedAccountsFile);
	}

	private function removeByToken($token) {
		$rememberedAccounts = @file($this->rememberedAccounts);
		if ($rememberedAccounts === false) {
			return;
		}

		foreach ($rememberedAccounts as $key => $rememberedAccount) {
			$account = explode(',', $rememberedAccount);
			$accountToken = $account[0];
			if ($accountToken == $token) {
				unset($rememberedAccounts[$key]);
			}
		}

		$data = implode('\n', array_values($rememberedAccounts));
		$rememberedAccountsFile = fopen($this->rememberedAccounts, 'w');
		fwrite($rememberedAccountsFile, $data);
		fclose($rememberedAccountsFile);
	}

	public function findRememberedUser($token) {
		$rememberedAccounts = @file($this->rememberedAccounts);
		$now = time()+1;
		
		if ($rememberedAccounts === false) {
			return false;
		}

		foreach ($rememberedAccounts as $rememberedAccount) {
			$account = explode(',', $rememberedAccount);
			$accountToken = $account[0];
			$accountName = $account[1];
			$accountExpiration = $account[2];

			if ($accountToken == $token) {
				if ($now < $accountExpiration) {
					return $accountName;
				}

				return false;
			}
		}

		return false;
	}
}