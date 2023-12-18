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
        "leavelist"=>array("process"=>true,"idIndexInUri"=>2),
        "managerolepermission"=>array("process"=>true,"idIndexInUri"=>2),
        "setSinglePermissionByRole"=>array("process"=>true,"idIndexInUri"=>2),
        "showcall"=>array("process"=>true,"idIndexInUri"=>2),
        "showcalledit"=>array("process"=>true,"idIndexInUri"=>3),
        "leads"=>array("process"=>true,"idIndexInUri"=>1),
    );
    
    public $dynaicRouteActions = array("addDynamicMaster","editMainMasterValue","saveMainMasterUpdatedValue","deleteMainMasterValue");
    public $dynaicLeaveActions = array("leavelist","leavecalendar");
    public $dynaicRolePermissionActions = array("managerolepermission","setSinglePermissionByRole");
    public $dynaicLeadsPermissionActions = array("showcall","email");
    public $dynaicLeadsCommunicationLeadsActions = array("leads");

}


?>