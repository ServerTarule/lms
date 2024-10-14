<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Menu
 *
 * @property int $id
 * @property string $title
 * @property string $class
 * @property string $icon
 * @property string $url
 * @property boolean $deleted
 * @property int $parent_id
 * * @property int $preference
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RuleCondition> $ruleconditions
 * @property-read int|null $ruleconditions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DynamicValue> $values
 * @property-read int|null $values_count
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Menu extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'class',
        'icon',
        'url',
        'parent_id' ,//Id of parent of current menu
        'preference' 
    ];

    private $descendants = [];

    
    public function submenus(){
        return $this->hasMany(Menu::class, 'parent_id');
    }
    
    public function children(){
        return $this->submenus()->with('children');
    }
    
    public function hasChildren(){
        if($this->children->count()){
            return true;
        }
        return false;
    }
    
    public function findDescendants(Menu $menu,$currentId=0){
        if($currentId !=  $menu->id) {
            $this->descendants[] = $menu->id;
        }
     
        if($menu->hasChildren()){
            foreach($menu->children as $child){
                $this->findDescendants($child);
            }
        }
    }

    public function getDescendants(Menu $menu, $currentId=0){
        $this->findDescendants($menu,$currentId);
        return $this->descendants;
    }






    public function buildMenu($array,$parent_id = 0)
    {
      $menu_html = '<li>';
      $menuArray = json_decode(json_encode($array),true);
      foreach($array as $element)
      {
        if($element['parent_id']==$parent_id)
        {
            $itemArray = json_decode(json_encode($element),true);
            $childrenArray = $this->getChildren($menuArray,$itemArray);

            if(count($childrenArray) > 0) {
                $liElement = '<li class="treeview">
                                    <a href="'.$element['url'].'">
                                    <i class="'.$element['icon'].'"></i>
                                    <span>'.$element['title'].'</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                            ';
                $menu_html .= $liElement.$this->buildMenu($array,$element['id']).'</ul>';                            
            }
            else {
                $liElement = '<li class="active">
                <a href="'.$element['url'].'"><i class="'.$element['icon'].'"></i><span>'.$element['title'].'</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>';
            $menu_html .= $liElement;
            }
        }
      }
      $menu_html .= '</li>';
      return $menu_html;
    }
    // Getter for the HTML menu builder
    public function getChildren($menuArray,$itemArray)
    {
        return $child = array_filter($menuArray, function ($menuItem) use ($itemArray) {
            return ($menuItem['parent_id'] == $itemArray['id']);
        });
    }

    // Getter for the HTML menu builder
    public function getHTML($items)
    {
        $html =  $this->buildMenu($items);
        return $html ;
    }

    public function values() : HasMany {
        //return $this->hasMany(DynamicValue::class,'parent_id');
    }

    public function ruleconditions() : HasMany {
        //return $this->hasMany(RuleCondition::class,'master_id');
    }

}
