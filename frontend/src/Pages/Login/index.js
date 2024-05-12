// src/Pages/Login/index.js
import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import './Login.css';
import illustration from './Fundo_Login.png';
import logo from './Logo_Agile.png';

const Login = () => {
    const [email, setEmail] = useState('');
    const [senha, setSenha] = useState('');
    const [error, setError] = useState('');
    const navigate = useNavigate();

    const handleSubmit = async (event) => {
        event.preventDefault();
        console.log(`Email: ${email}, Password: ${senha}`);

        try {
            const responde = await fetch('http://localhost:8000/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, senha })
            });
            const data = await responde.json();

            if (responde.ok) {
                localStorage.setItem('token', data.token)
                navigate('/home')
            }
            else
            {
                setError(data.mensagem);
            }
        }
        catch (error) {
            setError('Erro ao comunicar com servidor!' + error);
        }
    };

    return (
        <div className="login-wrapper">
            <div className="illustration">
                <img src={illustration} alt="Illustration" />
            </div>
            <div className="login-container">
                <div className="login-content">
                    <div className="logo">
                        <img src={logo} alt="Logo" />
                    </div>
                    <div className="login-header">
                        <p className="login-subtitle">Bem Vindo!<br />Realize seu login para começamos</p>
                    </div>
                    <form onSubmit={handleSubmit} className="login-form">
                        <div className="form-group">
                            <label>Email</label>
                            <input
                                type="email"
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                                required
                            />
                        </div>
                        <div className="form-group">
                            <label>Senha</label>
                            <input
                                type="password"
                                value={senha}
                                onChange={(e) => setSenha(e.target.value)}
                                required
                            />
                        </div>
                        <button type="submit" className="login-button">LOGAR</button>
                        {error && <p className="error-message">{error}</p>}
                        <div className="login-footer">
                            <p>É novo na plataforma? <a href="#">Criar Conta</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
};

export default Login;
