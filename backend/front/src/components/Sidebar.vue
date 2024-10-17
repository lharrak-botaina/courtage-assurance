<template>
    <aside class="sidebar">
      <div class="sidebar-header">
        <img src="../assets/cropped-NEWLOGO.webp" alt="logo" />
       
      </div>
      <ul class="sidebar-links">
        <li>
          <router-link to="/" class="router-link">
            <span class="material-symbols-outlined">  </span>Client
          </router-link>
        </li>
        <li>
          <router-link to="/voiture" class="router-link">
            <span class="material-symbols-outlined">  </span>Voiture
          </router-link>
        </li>
        <li>
          <router-link to="/devis" class="router-link">
            <span class="material-symbols-outlined">  </span>Devis
          </router-link>
        </li>
      
      </ul>
    </aside>
  
  </template>
  
  <script setup>
    
  </script>
  
  <style scoped>
  
  .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 260px; 
    display: flex;
    flex-direction: column;
    background:#302C55;
    padding: 25px 20px;
    box-shadow: 4px 0 8px rgba(0, 0, 0, 0.3);
  }
  
  .sidebar .sidebar-header {
    display: flex;
    align-items: center;
  }
  
  .sidebar .sidebar-header img {
    width: 139px;
    
  }
  
  .sidebar .sidebar-header h2 {
    color: #fff;
    font-size: 1.25rem;
    font-weight: 600;
    white-space: nowrap;
    margin-left: 23px;
  }
  
  .sidebar-links {
    list-style: none;
    margin-top: 20px;
    height: 80%;
    overflow-y: auto;
    scrollbar-width: none;
  }
  
  .sidebar-links::-webkit-scrollbar {
    display: none;
  }
  
  .sidebar-links li {
    margin-bottom: 10px;
  }
  
  .sidebar-links .router-link {
    display: flex;
    align-items: center;
    gap: 0 20px;
    color: #fff;
    font-weight: 500;
    white-space: nowrap;
    padding: 15px 10px;
    text-decoration: none;
    transition: 0.2s ease;
  }
  
  .sidebar-links .router-link:hover {
    color: #161a2d;
    background: #fff;
    border-radius: 4px;
  }
  </style>
  