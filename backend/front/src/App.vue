<template>
  <div class="app">
    <Sidebar/>
    <router-view/>
  </div>
</template>

<script setup>
import Sidebar from './components/Sidebar.vue';  
</script>


<style>
:root{
  --primary-color: #3498db;
  --light:#ffff;
  --sidebar-width:300px;
  --dark:#130434;
}
*{
margin: 0;
padding: 0;
box-sizing: border-box;
}
body{
  background: var(--dark);
}
.app{
  display: flex;
 
  
}
.app aside{
  padding: 30px;
}

</style>