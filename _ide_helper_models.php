<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\ActionType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ActionTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType whereUpdatedAt($value)
 */
	class ActionType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Center
 *
 * @property int $id
 * @property string $centerDetails
 * @property string $mobile
 * @property string $alternateMobile
 * @property string $state
 * @property string $city
 * @property string $ownerName
 * @property string $EmailId
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Center newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Center newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Center query()
 * @method static \Illuminate\Database\Eloquent\Builder|Center whereAlternateMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Center whereCenterDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Center whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Center whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Center whereEmailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Center whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Center whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Center whereOwnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Center whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Center whereUpdatedAt($value)
 */
	class Center extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\City
 *
 * @property int $id
 * @property string $name
 * @property int $state_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\State $state
 * @method static \Database\Factories\CityFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedAt($value)
 */
	class City extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Designation
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Designation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Designation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Designation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Designation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Designation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Designation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Designation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Designation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Designation whereUpdatedAt($value)
 */
	class Designation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Doctors
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Doctors newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctors newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctors query()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctors whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctors whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctors whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctors whereUpdatedAt($value)
 */
	class Doctors extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DynamicMain
 *
 * @property int $id
 * @property string $name
 * @property int $master
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RuleCondition> $ruleconditions
 * @property-read int|null $ruleconditions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DynamicValue> $values
 * @property-read int|null $values_count
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicMain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicMain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicMain query()
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicMain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicMain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicMain whereMaster($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicMain whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicMain whereUpdatedAt($value)
 */
	class DynamicMain extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DynamicValue
 *
 * @property int $id
 * @property string $name
 * @property int $parent_id
 * @property int|null $dependent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DynamicMain|null $dependent
 * @property-read \App\Models\DynamicMain|null $master
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RuleCondition> $ruleconditions
 * @property-read int|null $ruleconditions_count
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicValue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicValue whereDependentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicValue whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicValue whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicValue whereUpdatedAt($value)
 */
	class DynamicValue extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Employee
 *
 * @property int $id
 * @property string $name
 * @property string $contact
 * @property int $user_id
 * @property string $dob
 * @property string $doj
 * @property string $alternate_contact
 * @property int $designation_id
 * @property string $profile_img
 * @property string $lead_assigned_at
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Designation $designation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Lead> $leads
 * @property-read int|null $leads_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\EmployeeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAlternateContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDesignationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDoj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereLeadAssignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereProfileImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUserId($value)
 */
	class Employee extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmployeeRule
 *
 * @property int $id
 * @property int $employee_id
 * @property int $rule_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Employee> $employees
 * @property-read int|null $employees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rule> $rules
 * @property-read int|null $rules_count
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRule query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRule whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRule whereRuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRule whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRule whereUpdatedAt($value)
 */
	class EmployeeRule extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Lead
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $mobileno
 * @property string|null $altmobileno
 * @property string $receiveddate
 * @property string|null $remark
 * @property int|null $employee_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $employee
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LeadMaster> $leadmasters
 * @property-read int|null $leadmasters_count
 * @method static \Database\Factories\LeadFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Lead newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lead newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lead query()
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereAltmobileno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereMobileno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereReceiveddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereUpdatedAt($value)
 */
	class Lead extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LeadMaster
 *
 * @property int $id
 * @property int $lead_id
 * @property int $master_id
 * @property int|null $mastervalue_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Lead $lead
 * @property-read \App\Models\DynamicMain $master
 * @property-read \App\Models\DynamicValue|null $mastervalue
 * @method static \Illuminate\Database\Eloquent\Builder|LeadMaster newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadMaster newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadMaster query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadMaster whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadMaster whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadMaster whereLeadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadMaster whereMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadMaster whereMastervalueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadMaster whereUpdatedAt($value)
 */
	class LeadMaster extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LeaveManagement
 *
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveManagement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveManagement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveManagement query()
 */
	class LeaveManagement extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Rule
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RuleCondition> $ruleconditions
 * @property-read int|null $ruleconditions_count
 * @method static \Database\Factories\RuleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Rule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rule query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereUpdatedAt($value)
 */
	class Rule extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RuleCondition
 *
 * @property int $id
 * @property int $rule_id
 * @property int $master_id
 * @property int $mastervalue_id
 * @property string|null $condition
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DynamicMain $master
 * @property-read \App\Models\Rule $rule
 * @property-read \App\Models\DynamicValue|null $value
 * @method static \Database\Factories\RuleConditionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|RuleCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RuleCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RuleCondition query()
 * @method static \Illuminate\Database\Eloquent\Builder|RuleCondition whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RuleCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RuleCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RuleCondition whereMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RuleCondition whereMastervalueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RuleCondition whereRuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RuleCondition whereUpdatedAt($value)
 */
	class RuleCondition extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\State
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\StateFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|State newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|State newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|State query()
 * @method static \Illuminate\Database\Eloquent\Builder|State whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereUpdatedAt($value)
 */
	class State extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property int|null $role_id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property int $status
 * @property string|null $remember_token
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

