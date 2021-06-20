<?php

namespace skh6075\lib\positionutils;

use pocketmine\math\Vector3;
use pocketmine\Server;
use pocketmine\world\Position;
use pocketmine\world\World;

final class PositionUtils{

    public const CONVERT_TO_INT = 0;

    public const CONVERT_TO_FLOAT = 1;

    public static function posToStr(Position $pos, int $convert = self::CONVERT_TO_INT, bool $pushWorld = true): string{
        $result = "";
        switch ($convert) {
            case self::CONVERT_TO_INT:
                $result = implode(":", [
                    intval($pos->getX()),
                    intval($pos->getY()),
                    intval($pos->getZ())
                ]);
                break;
            case self::CONVERT_TO_FLOAT:
                $result = implode(":", [
                    floatval($pos->getX()),
                    floatval($pos->getY()),
                    floatval($pos->getZ())
                ]);
                break;
            default:
                break;
        }

        if ($pushWorld) {
            $result .= ":" . $pos->getWorld()->getFolderName();
        }

        return $result;
    }

    public static function strToPos(string $hash, int $convert = self::CONVERT_TO_INT, ?World $world = null): Position{
        $split = explode(":", $hash);
        $vec = null;
        switch ($convert) {
            case self::CONVERT_TO_INT:
                $vec = new Vector3(intval($split[0]), intval($split[1]), intval($split[2]));
                break;
            case self::CONVERT_TO_FLOAT:
                $vec = new Vector3(floatval($split[0]), floatval($split[1]), floatval($split[2]));
                break;
            default:
                break;
        }

        if (isset($split[3])) {
            $world = Server::getInstance()->getWorldManager()->getWorldByName($split[3]);
        }

        return Position::fromObject($vec, $world);
    }
}
