<template>
    <footer>
      <p>&copy; {{ new Date().getFullYear() }} Christopher Q Mendivel</p>
    </footer>
  </template>
  
  <script>
  export default {
    name: 'AppFooter'
  };
  </script>
  
  <style scoped>
  footer {
    background-color: #333;
    padding: 10px;
    color: white;
    text-align: center;
  }
  </style>
  