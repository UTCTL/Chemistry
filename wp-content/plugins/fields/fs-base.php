<?php

class FS_Base
{
  protected $hays = '';
  public $option_name = '';

  public function __construct($option_name)
  {
    $this->option_name = $option_name;
    $this->load();
  }
  
  function get($key)
  {
    foreach ($this->hays as $hay)
    {
      if (strcasecmp($hay['key'], $key) == 0)
        return $hay;
    }
    return false;
  }
  
  function get_index($key)
  {
    foreach ($this->hays as $k => $hay)
    {
      if (strcasecmp($hay['key'], $key) == 0)
        return $k;
    }
    return -1;
  }
  
  function from_index($index)
  {
    return $this->hays[$index];
  }
  
  function add($hay)
  {
    $item = $this->get($hay['key']);
    if (is_array($item))
      return $item;
    $this->hays[] = $hay;
    return true;
  }
  
  function replace($new_hay)
  {
    $index = $this->get_index($new_hay['key']);
    if ($index > -1)
    {
      $this->hays[$index] = $new_hay;
      return true;
    }
    return false;
  }
  
  function key_replace($key, $new_hay)
  {
    $index = $this->get_index($key);
    if ($index > -1)
    {
      $this->hays[$index] = $new_hay;
      return true;
    }
    return false;
  }
  
  function override($new_hay)
  {
    $index = $this->get_index($key);
    if ($index > -1)
    {
      return $this->replace($new_hay);
    }
    else
    {
      return $this->add($new_hay);
    }
  }
  
  function delete($key)
  {
    $index = $this->get_index($key);
    if ($index > -1)
    {
      $hay = $this->hays[$index];
      unset($this->hays[$index]);
      return $hay;
    }
    return false;
  }
  
  function hays()
  {
    return $this->hays;
  }
  
  function load()
  {
    $this->hays = get_option($this->option_name, '');
    if ($this->hays === '')
    {
      $this->create_dummy();
    }
    return $hays;
  }
  
  function update($sort = true)
  {
    if ($sort)
      sort_by_order(&$this->hays);    
    update_option($this->option_name, $this->hays);
  }
  
  function create_dummy()
  {
  }
  
}

?>