<?php

namespace Templates;

class DebugWindowTemplate
{

    /** @var string  */
    private string $data;

    /**
     * DebugWindowTemplate constructor.
     */
    public function __construct()
    {
$this->data = "<body>
<div class='p-1' id='checkboxes' onclick='toggle()'>
    <label for='server'>SERVER</label>
    <input type='checkbox' id='server'>
    
    <label for='post'>POST</label>
    <input type='checkbox' id='post'>
    
    <label for='get'>GET</label>
    <input type='checkbox' id='get'>
    
    <label for='session'>SESSION</label>
    <input type='checkbox' id='session'>
    
    <label for='cookie'>COOKIE</label>
    <input type='checkbox' id='cookie'>
    
    <label for='env'>ENV</label>
    <input type='checkbox' id='env'>
    
    <label for='file'>FILE</label>
    <input type='checkbox' id='file'>
    
    <label for='request'>REQUEST</label>
    <input type='checkbox' id='request'>
</div>

<div class='p-1'>
    <div id='server_block' style='display: none;'>
        <h6 class='h m-0'>SERVER</h6>
        <pre>~server~</pre>
    </div>
    
    <div id='post_block' style='display: none;'>
        <h6 class='h m-0'>POST</h6>
        <pre>~post~</pre>
    </div>
    
    <div id='get_block' style='display: none;'>
        <h6 class='h m-0'>GET</h6>
        <pre>~get~</pre>
    </div>
    
    <div id='session_block' style='display: none;'>
        <h6 class='h m-0'>SESSION</h6>
        <pre>~session~</pre>
    </div>
    
    <div id='cookie_block' style='display: none;'>
        <h6 class='h m-0'>COOKIE</h6>
        <pre>~cookie~</pre>
    </div>
    
    <div id='env_block' style='display: none;'>
        <h6 class='h m-0'>ENV</h6>
        <pre>~env~</pre>
    </div>
    
    <div id='file_block' style='display: none;'>
        <h6 class='h m-0'>FILE</h6>
        <pre>~file~</pre>
    </div>
    
    <div id='request_block' style='display: none;'>
        <h6 class='h m-0'>REQUEST</h6>
        <pre>~request~</pre>
    </div>
</div>

<script>
function toggle() {
  let checks = document.getElementById('checkboxes').getElementsByTagName('input');

  for (let i = 0; i < checks.length; i++){
    let el = document.getElementById(checks[i].id + '_block');
    
    if (checks[i].checked) {
        console.log(el.id);
      el.style.display = 'block';
    } else {
      el.style.display = 'none';
    }
  }
}
</script>

</body>
";
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }
}
