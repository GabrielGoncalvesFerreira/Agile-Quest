import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import './home.css';

const Home = () => {
  const [categorias, setCategorias] = useState([]);
  const [erro, setErro] = useState(null);
  const navigate = useNavigate();

  useEffect(() => {
    const fetchCategorias = async () => {
      try {
        const token = localStorage.getItem('token');
        const response = await fetch('http://localhost:8000/categorias', {
          headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
          },
        });
        const data = await response.json();
        if (response.ok) {
          setCategorias(data.categorias);
        } else {
          setErro(data.mensagem);
          navigate('/'); // Redireciona para login se houver erro
        }
      } catch (error) {
        setErro('Erro ao carregar categorias');
      }
    };

    fetchCategorias();
  }, [navigate]); // [] para executar apenas uma vez após a montagem

  if (erro) {
    return <p>{erro}</p>;
  }

  return (
    <div className="languages-container">
      {categorias.map((categoria, index) => (
        <div key={index} className="language-card">
          <img src={`/images/${categoria.image}`} alt={categoria.nome} />
          <p>{categoria.nome}</p>
        </div>
      ))}
    </div>
  );
};

export default Home;
