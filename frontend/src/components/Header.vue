<template>
    <header>
      <nav>
        <ul>
          <li><router-link to="/">Inicio</router-link></li>
          <li><router-link to="/clinicas">Clínicas</router-link></li>
          <li><router-link to="/empleados">Empleados</router-link></li>
        </ul>
      </nav>
    </header>
  </template>
  
  <script>
  export default {
    name: 'AppHeader'
  };
  </script>
  
  <style scoped>
  header {
    background-color: #333;
    padding: 10px;
    color: white;
  }
  
  nav ul {
    list-style-type: none;
    padding: 0;
  }
  
  nav ul li {
    display: inline;
    margin-right: 10px;
  }
  
  nav ul li a {
    color: white;
    text-decoration: none;
  }
  </style>
  