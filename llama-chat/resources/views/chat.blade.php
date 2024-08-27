<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot LLaMA</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .chat-container {
            width: 70rem;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .chat-header {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }
        #chat-box {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
        }
        .message {
            margin-bottom: 15px;
            max-width: 80%;
            word-wrap: break-word;
            padding: 10px;
            border-radius: 8px;
            clear: both;
        }
        .user-message {
            background-color: #007bff;
            color: #fff;
            float: right;
        }
        .bot-message {
            background-color: #f1f1f1;
            color: #333;
            float: left;
        }
        .chat-footer {
            padding: 10px;
            background-color: #f7f7f7;
            display: flex;
            align-items: center;
            border-top: 1px solid #ddd;
        }
        #user-input {
            flex: 1;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
        }
        #send-button, #clear-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        #clear-button {
            background-color: #dc3545;
            margin-left: 10px;
        }
        #clear-button:hover, #send-button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            Chatbot com LLaMA3.1
        </div>
        <div id="chat-box">
            <!-- As mensagens aparecerão aqui -->
        </div>
        <div class="chat-footer">
            <input type="text" id="user-input" placeholder="Digite sua mensagem...">
            <button id="send-button">Enviar</button>
            <button id="clear-button">Limpar</button>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Função para enviar mensagens
            $('#send-button').on('click', function() {
                let userInput = $('#user-input').val();
                if (userInput.trim() !== '') {
                    $('#chat-box').append('<div class="message user-message">Você: ' + userInput + '</div>');
                    $.ajax({
                        url: '/send-message',
                        method: 'POST',
                        data: {
                            text: userInput,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#chat-box').append('<div class="message bot-message">Miran: ' + response + '</div>');
                            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            $('#chat-box').append('<div class="message bot-message">Erro: ' + errorThrown + '</div>');
                        }
                    });
                    $('#user-input').val('');
                }
            });

            // Função para limpar a tela
            $('#clear-button').on('click', function() {
                $('#chat-box').html('');
            });

            // Enviar mensagem ao pressionar Enter
            $('#user-input').keypress(function(e) {
                if (e.which == 13) {
                    $('#send-button').click();
                }
            });
        });
    </script>
</body>
</html>

