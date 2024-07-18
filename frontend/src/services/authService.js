export async function login(email, password) {
  try {
    const response = await fetch('http://localhost:8000/api/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ email, password })
    });

    if (response.ok) {
      const data = await response.json();
      localStorage.setItem('user', JSON.stringify(data.user)); 
      return data;
    } else {
      throw new Error('Credenciales inválidas');
    }
  } catch (error) {
    console.error('Login error:', error);
    throw error;
  }
}

export function logout() {
  return fetch('http://localhost:8000/api/logout', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    credentials: 'include' // Enviar cookies con la solicitud
  })
  .then(() => {
    localStorage.removeItem('user'); 
  });
}

export function isLoggedIn() {
  return !!localStorage.getItem('user'); 
}
