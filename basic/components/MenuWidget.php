<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018-12-14
 * Time: 22:11
 */
namespace app\components;
use yii\base\Widget;
use app\models\Category;

class MenuWidget extends Widget
{
    public $tpl;
    public $data; //Здесь будут храниться все категории из БД
    public $tree;// Здесь будет храниться результат работы функции озвученной выше которая будет из массива строить массив дерево
    public $menuHtml; // Здесь будет храниться готовый HTML код

    public function init()
    {
      parent::init();
      if($this->tpl === null){
          $this->tpl = 'menu';
      }
      /*Прикрепляем расширение php*/
        $this->tpl .= '.php';
    }

    public function run()
    {
        $this->data = Category::find()->indexBy('id')->asArray()->all();
        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree);
        return $this->menuHtml;
    }

    /*Создаем функцию которая будет превращать массив в массив дерево*/
    public function getTree() {
        $tree = [];
        foreach ($this->data AS $id => &$node)
        {
            if(!$node['parent_id'])
                $tree[$id] = &$node;
            else
                $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
        }
        return $tree;
    }

    protected function getMenuHtml($tree){
        $str = ''; //Сюда будем помещать готовый HTML код
        foreach($tree as $category){
            $str .= $this->catToTemplate($category);
        }
        return $str;
    }

    /*Функция возвращает буферизированный вывод в переменную str*/
    protected function catToTemplate($category){
        ob_start(); //Буферизируем вывод
        include __DIR__ . '/menu_tpl/' . $this->tpl;
        return ob_get_clean(); //Возвращает результат не выводя на экран
    }
}