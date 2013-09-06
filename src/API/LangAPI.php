<?php

/**
 *
 *  ____            _        _   __  __ _                  __  __ ____  
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \ 
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/ 
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_| 
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 * 
 *
*/

	class LangAPI{
		public static $instance = false;
		public static $translations = array();
		public static $lang = array("en", "en_US", "us");
		public function __construct(){
			$this->server = ServerAPI::request();
			$this->loadTranslations();
			self::$instance = $this;
			if(($locale = $this->server->api->getProperty("locale", false)) !== false){
				$this->setLang($locale);
			}
		}
		
		public function setLang($lang){
			if(!is_array($lang)){
				$lang = self::langData($lang);
			}
			if(isset(self::$translations[$lang[0]][$lang[1]])){
				self::$lang = $lang;
				console("[INFO] Language set to ".self::get("language.name")." [".self::$lang[1]."]");
				return true;
			}
			return false;
		}
		
		public function getLang(){
			return (self::$lang);
		}
		
		public static function langData($lang){
			$locale = preg_replace("/[^a-z_]/", "", str_replace(array("-", "jp_jp"), array("_", "ja_jp"), substr(strtolower(trim($lang)), 0, 6)));
			return array("code" => explode("_", $locale[0]), "locale" => isset($locale[1]) ? $locale[0]."_".strtoupper($locale[1]):$locale[0]."_".strtoupper($locale[0]), "code" => isset($locale[1]) ? $locale[1]:$locale[0]);
		}
		
		public static function set($identifier, $value, $lang = false){
			if($lang !== false){
				if(!is_array($lang)){
					$lang = self::langData($lang);
				}
			}else{
				$lang = self::$lang;
			}
			if(!isset(self::$translations[$lang[0]][$lang[1]])){
				return false;
			}
			self::$translations[$lang[0]][$lang[1]][$identifier] = (string) $value;
			return true;
		}
		
		public static function get($identifier, $replace = array(), $lang = false){
			if($lang !== false){
				if(!is_array($lang)){
					$lang = self::langData($lang);
				}
			}else{
				$lang = self::$lang;
			}
			
			if(isset(self::$translations[$lang[0]][$lang[1]][$identifier])){
				if(count($replace) > 0){
					array_unshift($replace, self::$translations[$lang[0]][$lang[1]][$identifier]);
					return call_user_func_array("sprintf", $replace);
				}
				return self::$translations[$lang[0]][$lang[1]][$identifier];
			}elseif(isset(self::$translations["en"]["en_US"][$identifier])){
				if(count($replace) > 0){
					array_unshift($replace, self::$translations["en"]["en_US"][$identifier]);
					return call_user_func_array("sprintf", $replace);
				}
				return self::$translations["en"]["en_US"][$identifier];
			}else{
				return $identifier;
			}
		}
		
		public function loadTranslations(){
			self::$translations = array();
			if(defined("POCKETMINE_COMPILED") and POCKETMINE_COMPILED === true){
			
			}else{
				$all = glob(FILE_PATH."src/lang/*.lang");
				foreach($all as $file){
					$parsed = array();
					foreach(explode("\n", str_replace("\r", "", @file_get_contents($file))) as $line){
						$line = trim($line);
						if($line === ""){
							continue;
						}
						$data = explode("=", str_replace("\/\/", "//", $line));
						if(!isset($data[1])){
							continue;
						}
						$parsed[array_shift($data)] = implode("=", $data);
					}
					
					if(!isset($parsed["language.code"]) or !isset($parsed["language.locale"]) or !isset($parsed["language.name"])){ //Invalid language
						continue;
					}
					
					if(!isset(self::$translations[$parsed["language.code"]])){
						self::$translations[$parsed["language.code"]] = array();
					}
					
					if(isset(self::$translations[$parsed["language.code"]][$parsed["language.locale"]])){ //Translation already exists
						continue;
					}
					self::$translations[$parsed["language.code"]][$parsed["language.locale"]] = $parsed;
				}
			}
		}
	}