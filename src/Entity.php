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


class Entity{
	public static $entityCount = 0;
	private $id;
	public $lastX;
	public $lastY;
	public $lastZ;
	public $locX;
	public $locY;
	public $locZ;
	public $motX;
	public $motY;
	public $motZ;
	public $yaw;
	public $pitch;
	public $lastYaw;
	public $lastPitch;
	public $onGround = false;
	public $level;
	public $positionChanged = false;
	public $velocityChanged = false;
	public $dead = false;
	public $height;
	public $width;
	public $length;
	public $fallDistance;
	public $ticksLived;
	public $maxFireTicks;
	public $fireTicks;
	public $inWater = false;
	public $noDamageTicks;
	public $fireProof = false;
	public $invulnerable = false;
	private $justCreated = false;
	
	/** Returns the Entity id */
	final public function getId(){
		return $this->id;
	}
	
	public function __construct(Level $level){
		$this->id = self::$entityCount++;
		$this->width = 0.6;
		$this->length = 1.8;
		$this->maxFireTicks = 1;
		$this->justCreated = true;
		$this->level = $level;
		$this->setPosition(new Vector3(0, 0, 0));
		$this->setVelocity(new Vector3(0, 0, 0));
	}
	
	public function die(){
		$this->dead = true;
	}
	
	public function setPosition(Vector3 $pos){
		if(($pos instanceof Level) and $pos->level !== $this->level){
			//TODO
		}
		$this->
	}
	
	public function setVelocity(Vector3 $velocity){

		$this->velocity = $velocity;
	}
	
	public function getVelocity(){
		return $this->velocity;
	}
	
	public function isOnGround(){
		return $this->onGround == true;
	}
	
	public function getLevel(){
		return $this->level;
	}
	
	public function getNearbyEntities($x, $y, $z){
		//TODO
	}
	
	public function getEntityId(){
	}
	
	abstract public function isDamageable();

}