<?php
namespace App\Http\Middleware;

class PreMappedAuthorizationRoutes {
    // public $authorizationRoutes = array(
    //     "addDynamicMaster"=>"/master/main/1",
    //     "editMainMasterValue"=>"/master/main/1",
    //     "saveMainMasterUpdatedValue"=>"/master/main/1",
    // );
    public $dynamicMasterAuthorizationRoutes = array(
        "addDynamicMaster"=>array("process"=>true,"idIndexInUri"=>2),
        "editMainMasterValue"=>array("process"=>true,"idIndexInUri"=>4),
        "saveMainMasterUpdatedValue"=>array("process"=>true,"idIndexInUri"=>4),
        "deleteMainMasterValue"=>array("process"=>true,"idIndexInUri"=>4),
    );
    
    public $dynaicRouteActions = array("addDynamicMaster","editMainMasterValue","saveMainMasterUpdatedValue","deleteMainMasterValue");
}


?>