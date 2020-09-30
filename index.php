<?php

class Rabbit
{
    private $_Speed, $_Color = ['white', 'brown'], $_NbKmTraveled, $_Position;

    //getters
    public function getSpeed()
    {
        return $this->_Speed;
    }
    public function getColor()
    {
        return $this->_Color;
    }
    public function getNbKmTraveled()
    {
        return $this->_NbKmTraveled;
    }
    public function getPosition()
    {
        return $this->_Position;
    }

    //setters
    private function setSpeed($speed)
    {
        $this->_Speed = $speed;
    }
    private function setColor()
    {
        $this->_Color = $this->_Color[mt_rand(0, count($this->_Color) - 1)];
    }
    public function setNbKmTraveled($nbKmTraveled)
    {
        $this->_NbKmTraveled = $nbKmTraveled;
    }
    public function setPosition(array $position)
    {
        $this->_Position = $position;
    }

    public function __construct()
    {
        $this->setSpeed(mt_rand(0, 10));
        $this->setColor();
        $this->setNbKmTraveled(0);
        $this->setPosition([mt_rand(0, Forest::getTotalSquareKm()), mt_rand(0, Forest::getTotalSquareKm())]);
    }

    public function Pursued(): void
    {
        if (mt_rand(0, 1) == 0) { //50% chance of finding a hole
            foreach (Forest::getHoles() as $hole) {
                if (!array_diff_assoc($hole->getPosition(), $this->getPosition()) && $hole->getOccuped() == false) {
                    $hole->setOccuped(true);
                    $this->setPosition([11, 11]); //subjective address to place the rabbit out of the forest and maintain it existing
                }
            }
        }
    }
}

class Hole
{
    private $_Position, $_Occuped;

    //getters
    public function getPosition()
    {
        return $this->_Position;
    }
    public function getOccuped()
    {
        return $this->_Occuped;
    }
    //setters
    private function setPosition()
    {
        $this->_Position = [mt_rand(0, Forest::getTotalSquareKm()), mt_rand(0, Forest::getTotalSquareKm())];
    }
    public function setOccuped($occuped)
    {
        $this->_Occuped = $occuped;
    }

    public function __construct()
    {
        $this->setOccuped(rand(0, 1) == 1);
        $this->setPosition();
    }
}

class Forest
{
    private static $_Holes, $_Rabbits, $_Trees, $_TotalSquareKm;

    //getters
    public static function getHoles()
    {
        return self::$_Holes;
    }
    public static function getRabbits()
    {
        return self::$_Rabbits;
    }
    public static function getTotalSquareKm()
    {
        return self::$_TotalSquareKm;
    }
    public  static function getTrees()
    {
        return self::$_Trees;
    }
    //setters
    private function setNbHoles($nbHoles)
    {
        for ($i = 0; $i <= $nbHoles - 1; $i++)
            self::$_Holes[] = new Hole;
    }
    private function setNbRabbits($nbRabbits)
    {
        for ($i = 0; $i <= $nbRabbits - 1; $i++)
            self::$_Rabbits[] = new Rabbit;
    }
    private function setTotalSquareKm($totalSquareKm)
    {
        self::$_TotalSquareKm = $totalSquareKm;
    }
    private function setNbTrees($nbTrees)
    {
        for ($i = 0; $i <= $nbTrees - 1; $i++) {
            self::$_Trees[] = [mt_rand(0, self::$_TotalSquareKm), mt_rand(0, self::$_TotalSquareKm)];
        }
    }

    public function __construct()
    {
        $this->setTotalSquareKm(mt_rand(1, 10));
        $this->setNbHoles(mt_rand(1, 100000));
        $this->setNbRabbits(mt_rand(1, 10000));
        $this->setNbTrees(mt_rand(0, 1000));
    }
}

$forest = new Forest;

class Hunter
{
    private $_NbBullets, $_SatietyLevel, $_NbKmTraveled, $_Position;

    //getters
    public function getNbBullets()
    {
        return $this->_NbBullets;
    }
    public function getSatietylevel()
    {
        return $this->_SatietyLevel;
    }
    public function getNbKmTraveled()
    {
        return $this->_NbKmTraveled;
    }
    public function getPosition()
    {
        return $this->_Position;
    }

    //setters
    public function setNbBullets($nbBullets)
    {
        $this->_NbBullets = $nbBullets;
    }
    public function setSatietyLevel($satietyLevel)
    {
        $this->_SatietyLevel = $satietyLevel;
    }
    public function setNbKmTraveled($nbKmTraveled)
    {
        $this->_NbKmTraveled = $nbKmTraveled;
    }
    public function setPosition($position)
    {
        $this->_Position = $position;
    }

    public function __construct()
    {
        $this->setNbBullets(mt_rand(1, 10));
        $this->setSatietyLevel(mt_rand(1, 10));
        $this->setNbKmTraveled(0);
        $initOfPosition = [[mt_rand(0, Forest::getTotalSquareKm()), 0], [mt_rand(0, Forest::getTotalSquareKm()), Forest::getTotalSquareKm()], [0, mt_rand(0, Forest::getTotalSquareKm())], [Forest::getTotalSquareKm(), mt_rand(0, Forest::getTotalSquareKm())]];
        $this->_Position = $initOfPosition[mt_rand(0, count($initOfPosition) - 1)];
    }

    public function huntTheRabbits(): void
    {
        /**
         * @param object $object
         * @return void
         */
        function Move(object $object)
        {
            $initPosition = $object->getPosition();
            $mtRand01 = mt_rand(0, 1);
            $mtRand10 = mt_rand(-1, 0);
            $mtRand11 = mt_rand(-1, 1);
            if (array_diff([11, 11], $object->getPosition())) { //If it's a rabbit and it's hidden in a hole, then the rest of the game remains hidden there.
                if (mt_rand(0, 1) == 0) { // X axe
                    if ($object->getPosition()[0] == 0) {
                        $object->setPosition([$object->getPosition()[0] += $mtRand01, $object->getPosition()[1]]);
                    } elseif ($object->getPosition()[0] == Forest::getTotalSquareKm()) {
                        $object->setPosition([$object->getPosition()[0] += $mtRand10, $object->getPosition()[1]]);
                    } else {
                        $object->setPosition([$object->getPosition()[0] += $mtRand11, $object->getPosition()[1]]);
                    }
                } else { // Y axe
                    if ($object->getPosition()[1] == 0) {
                        $object->setPosition([$object->getPosition()[0], $object->getPosition()[1] += $mtRand01]);
                    } elseif ($object->getPosition()[1] == Forest::getTotalSquareKm()) {
                        $object->setPosition([$object->getPosition()[0], $object->getPosition()[1] += $mtRand10]);
                    } else {
                        $object->setPosition([$object->getPosition()[0], $object->getPosition()[1] += $mtRand11]);
                    }
                }
            }
            if (array_diff_assoc($initPosition, $object->getPosition())) {
                $object->setNbKmTraveled($object->getNbKmTraveled() + 1);
            }
        } //End Move()

        /**
         * @param object $rabbit
         * @param int $probToEchec
         * @return string
         */
        function shotTheRabbit(object $rabbit, int $probToEchec)
        {
            $story = '';
            if (mt_rand(0, $probToEchec) == 0) { //Probability of missed shot
                $story .= 'shot ...but it is a tree that receives the shot. </br>';
            } elseif (mt_rand(0, $rabbit->getSpeed()) == 0) {
                $story .= 'Shooting...misses the rabbit by little because it moved too fast.</br>';
                $rabbit->Pursued();
            } else {
                $story .= 'shooting ...but the rabbit has nothing ...</br> His daughter, had replaced the buckshot by coarse salt...But shh he just thinks he shot badly.  </br>';
            }
            return $story;
        } // End shotTheRabbit()

        function display($object, $story)
        {
            echo '<tr>
        <td>' . $object->getNbKmTraveled() . '</td>
        <td> ' . $story . '</td>
        <td>' . $object->getNbBullets() . '</td>
        <td>' . $object->getSatietylevel() . '</td>
        </tr>';
        } //End display()

        $nbRabbitsSeen = 0;

        //Loop Script -----------------------------------------------------
        while ($this->getSatietylevel() > 0 && $this->getNbBullets() > 0 && $this->getNbKmTraveled() < 10) {
            //move the hunter
            Move($this);
            //move the rabbits
            foreach (Forest::getRabbits() as $rabbit) {
                Move($rabbit);
            }

            //Nb of trees in the same zone as the hunter
            $treesInZone = 0;
            foreach (Forest::getTrees() as $tree) {
                if (!array_diff_assoc($this->getPosition(), $tree)) {
                    $treesInZone++;
                }
            }
            //Probability of echec if 0 //TODO
            if ($treesInZone < 20) {
                $probToEchec = mt_rand(0, 7); // 12.5%
            } elseif ($treesInZone < 35) {
                $probToEchec = mt_rand(0, 4); // 20%
            } elseif ($treesInZone < 70) {
                $probToEchec = mt_rand(0, 2); // 33%
            } else {
                $probToEchec = mt_rand(0, 1); // 50%
            }

            $story = '';
            $rabbitsInTheZone = 0;

            //Detects if a rabbit is present around the hunter.
            foreach (Forest::getRabbits() as $rabbit) {

                if (!array_diff_assoc($this->getPosition(), $rabbit->getPosition())) {
                    $rabbitsInTheZone++;

                    //if yes then calculate the probability of seeing it according to the number of trees in the immediate neighbourhood.
                    if ($probToEchec == 0) { //The hunter can see the rabbit

                        $nbRabbitsSeen++;

                        $story .= 'Bob sees a rabbit, '; //TODO

                        if (mt_rand(0, 1) == 0) { //Is it within shot's range?
                            $story .= 'it is within shooting range. </br>'; //TODO
                            // if Yes -> First shoot
                            $story .= 'He points it out and ';
                            $story .= shotTheRabbit($rabbit, $probToEchec);
                            $this->setNbBullets($this->getNbBullets() - 1);
                            $this->setSatietyLevel($this->getSatietylevel() - 1);
                        } else { // if No, attempt to get close discreetly
                            $story .= 'but this one is not within shooting range, it has to get closer. </br>';
                            if (mt_rand(0, 1) == 0) {
                                $story .= 'Lucky ! He manages to get close without being noticed, puts him in the face and ';
                                $story .= shotTheRabbit($rabbit, $probToEchec);
                                $this->setNbBullets($this->getNbBullets() - 1);
                                $this->setSatietyLevel($this->getSatietylevel() - 1);
                            } else { //the rabbit detects the hunter and runs away
                                $story .= 'Damn! When he wanted to get closer he made too much noise and scared the rabbit away. </br>';
                                $this->setSatietyLevel($this->getSatietylevel() - 1);
                                $rabbit->Pursued();
                            }
                        }

                        if ($this->getNbKmTraveled() == 10) {
                            $story .= 'After walking 10km, Bob is tired and decides to go home.';
                        } elseif ($this->getNbBullets() == 0) {
                            $story .= 'Bob has no more bullets and decides to go home.';
                        } elseif ($this->getSatietylevel() == 0) {
                            $story .= 'Bob is too hungry and decides to go home.';
                        }

                        //Display Story
                        display($this, $story);
                    }
                    break;
                }
            } //End foreach($rabbit)
            if ($this->getNbKmTraveled() == 10 && $nbRabbitsSeen != 0 && ($probToEchec != 0 || $rabbitsInTheZone == 0)) {
                $story .= 'After having walked 10km, Bob, tired, decides to go home.';
                display($this, $story);
            }
        } //End While()
        if ($nbRabbitsSeen == 0 || $rabbitsInTheZone == 0) {
            $story = 'After 10km of walking and not a single rabbit in sight, Bob, tired, decides to go home.';
            display($this, $story);
        }
    } //End function huntTheRabbit()
} //End class Hunter{}


$bobTheHunter = new Hunter;

require('view.php');
