// src/Pages/Quiz/index.js
import React, { useState } from 'react';
import { Button, Container, Row, Col, Card } from 'react-bootstrap';
import './Quiz.css';

const perguntas = [
  {
    pergunta: 'Qual a linguagem de programação usada para a criação de páginas web interativas?',
    opcoes: ['Python', 'C', 'Java', 'JavaScript'],
  },
  {
    pergunta: 'Qual a linguagem de programação conhecida por sua simplicidade e uso em ciência de dados?',
    opcoes: ['C++', 'Ruby', 'Python', 'Go'],
  },
  {
    pergunta: 'Qual linguagem foi criada por James Gosling e é amplamente usada para desenvolvimento de aplicativos?',
    opcoes: ['Java', 'Swift', 'Perl', 'PHP'],
  },
  {
    pergunta: 'Qual linguagem é amplamente utilizada para o desenvolvimento de aplicativos móveis para iOS?',
    opcoes: ['C', 'Swift', 'Assembly', 'Kotlin'],
  },
  {
    pergunta: 'Qual linguagem de programação é conhecida como a linguagem da web?',
    opcoes: ['Rust', 'TypeScript', 'HTML', 'JavaScript'],
  }
];

const Quiz = () => {
  const [indicePerguntaAtual, definirIndicePerguntaAtual] = useState(0);
  const [respostasSelecionadas, definirRespostasSelecionadas] = useState([]);

  const selecionarOpcao = (opcao) => {
    const novasRespostas = [...respostasSelecionadas];
    novasRespostas[indicePerguntaAtual] = opcao;
    definirRespostasSelecionadas(novasRespostas);
  };

  const proximaPergunta = () => {
    if (indicePerguntaAtual < perguntas.length - 1) {
      definirIndicePerguntaAtual(indicePerguntaAtual + 1);
    } else {
      alert('Quiz finalizado! Respostas enviadas!');
      console.log('Respostas:', respostasSelecionadas);
      // Aqui você pode enviar as respostas para um servidor ou processar de outra forma
    }
  };

  const perguntaAtual = perguntas[indicePerguntaAtual];

  return (
    <Container className="quiz-wrapper">
      <Row className="align-items-center">
        <Col md={8} className="mx-auto">
          <Card className="quiz-container">
            <Card.Body>
              <h3 className="question">Pergunta {indicePerguntaAtual + 1}:</h3>
              <p className="question-text">{perguntaAtual.pergunta}</p>
              <ul className="options">
                {perguntaAtual.opcoes.map((opcao, indice) => (
                  <li
                    key={indice}
                    className={`option ${respostasSelecionadas[indicePerguntaAtual] === opcao ? 'selected' : ''}`}
                    onClick={() => selecionarOpcao(opcao)}
                  >
                    {opcao}
                  </li>
                ))}
              </ul>
              <Button
                onClick={proximaPergunta}
                className="next-button"
                disabled={!respostasSelecionadas[indicePerguntaAtual]}
              >
                {indicePerguntaAtual < perguntas.length - 1 ? 'Próxima Pergunta' : 'Finalizar Quiz'}
              </Button>
            </Card.Body>
          </Card>
        </Col>
      </Row>
    </Container>
  );
};

export default Quiz;
