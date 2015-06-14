<?php
namespace falkirks\simplewarp\lang;


use falkirks\simplewarp\api\SimpleWarpAPI;
use falkirks\simplewarp\store\DataStore;
use falkirks\simplewarp\store\Reloadable;
use falkirks\simplewarp\store\Saveable;
use pocketmine\utils\TextFormat;

/**
 * This class is currently not implemented in any of SimpleWarp's utilities
 * Class TranslationManager
 * @package falkirks\simplewarp\lang
 */
class TranslationManager {
    /** @var  SimpleWarpAPI */
    private $api;
    /** @var  DataStore */
    private $store;

    public function __construct(SimpleWarpAPI $api, DataStore $store){
        $this->api = $api;
        $this->store = $store;
        $this->registerDefaults();
        $this->save();

    }
    public function get($name){
        return $this->store->get($name);
    }
    public function execute($name, ...$args){
        if($args === null || count($args) === 0){
            return $this->get($name);
        }
        if(is_array($args[0])){
            $args = $args[0];
        }
        return  sprintf($this->get($name), ...$args);
    }
    protected function registerDefaults(){
        $this->registerDefault("addwarp-cmd", "addwarp");
        $this->registerDefault("addwarp-desc", "Add new warps.");
        $this->registerDefault("addwarp-usage", "/addwarp <name> [<ip> <port>|<x> <y> <z> <level>|<player>]");

        $this->registerDefault("closewarp-cmd", "closewarp");
        $this->registerDefault("closewarp-desc", "Close existing warps.");
        $this->registerDefault("closewarp-usage", "/closewarp <name>");

        $this->registerDefault("delwarp-cmd", "delwarp");
        $this->registerDefault("delwarp-desc", "Delete existing warps.");
        $this->registerDefault("delwarp-usage", "/delwarp <name>");

        $this->registerDefault("listwarps-cmd", "listwarps");
        $this->registerDefault("listwarps-desc", "List all your warps.");
        $this->registerDefault("listwarps-usage", "/listwarps");

        $this->registerDefault("openwarp-cmd", "openwarp");
        $this->registerDefault("openwarp-desc", "Open existing warps.");
        $this->registerDefault("openwarp-usage", "/openwarp <name>");

        $this->registerDefault("warp-cmd", "warp");
        $this->registerDefault("warp-desc", "Warp around your world.");
        $this->registerDefault("warp-usage", "/warp <name> [player]");

        $this->registerDefault("warp-added-xyz", "You have created a warp called " . TextFormat::AQUA . "%s" . TextFormat::RESET . " %s");
        $this->registerDefault("warp-added-player", "You have created a warp called " . TextFormat::AQUA . "%s" . TextFormat::RESET . " %s");
        $this->registerDefault("warp-added-server", "You have created a warp called " . TextFormat::AQUA . "%s" . TextFormat::RESET . " %s");
        $this->registerDefault("warp-added-self", "You have created a warp called " . TextFormat::AQUA . "%s" . TextFormat::RESET . " %s");

        $this->registerDefault("level-not-loaded", TextFormat::RED . "You specified a level which isn't loaded." . TextFormat::RESET);

        $this->registerDefault("needs-fast-transfer", "This warp needs " . TextFormat::AQUA . "FastTransfer" . TextFormat::RESET . ", you will need to install it to use this warp.");

        $this->registerDefault("player-not-loaded", TextFormat::RED . "You specified a player which isn't loaded." . TextFormat::RESET);

        $this->registerDefault("addwarp-noperm", TextFormat::RED . "You don't have permission to use this command" . TextFormat::RESET);

        $this->registerDefault("bad-warp-name", TextFormat::RED . "That warp name is invalid." . TextFormat::RESET);

        $this->registerDefault("closed-warp-1", "You have closed a warp called " . TextFormat::AQUA . "%s" . TextFormat::RESET);
        $this->registerDefault("closed-warp-2", "  Only players with the permission " . TextFormat::AQUA . "%s" . TextFormat::RESET . " will be able to use this warp.");
        $this->registerDefault("warp-doesnt-exist", TextFormat::RED . "That warp doesn't exist." . TextFormat::RESET);
        $this->registerDefault("closewarp-noperm", TextFormat::RED . "You don't have permission to use this command" . TextFormat::RESET);

        $this->registerDefault("warp-deleted", "You have deleted a warp called " . TextFormat::AQUA . "%s" . TextFormat::RESET);
        $this->registerDefault("delwarp-noperm", TextFormat::RED . "You don't have permission to use this command" . TextFormat::RESET);

        $this->registerDefault("opened-warp-1", "You have opened a warp called " . TextFormat::AQUA . "%s" . TextFormat::RESET);
        $this->registerDefault("opened-warp-2", "  Any player will be able to use this warp.");
        $this->registerDefault("openwarp-noperm", TextFormat::RED . "You don't have permission to use this command" . TextFormat::RESET);

        $this->registerDefault("warping-popup", "Warping...");
        $this->registerDefault("other-player-warped", "%s  has been warped to " . TextFormat::AQUA . "%s" . TextFormat::RESET . ".");
        $this->registerDefault("no-permission-this-warp", TextFormat::RED . "You don't have permission to use this warp." . TextFormat::RESET);
        $this->registerDefault("no-permission-warp-other", TextFormat::RED . "You don't have permission to warp other players." . TextFormat::RESET);
        $this->registerDefault("warp-done", "You have been warped");
        $this->registerDefault("warp-noperm", TextFormat::RED . "You don't have permission to use this command" . TextFormat::RESET);

    }
    protected function registerDefault($name, $text){
        if(!$this->store->exists($name)){
            $this->store->add($name, $text);
        }
    }
    public function reload(){
        if($this->store instanceof Reloadable){
            $this->store->reload();
        }
    }
    protected function save(){
        if($this->store instanceof Saveable){
            $this->store->save();
        }
    }

}