    <?php
        // Include the OpenAI Assistant PHP SDK
        require_once 'php-open-ai-assistant-sdk-main/src/OpenAIAssistant.php';

        // Process the user input and interact with the OpenAI Assistant API
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userInput'])) {
            $api_key = '___'; 
            $assistant_id = '_____';  

            $openai = new \Erdum\OpenAIAssistant($api_key, $assistant_id);
            $userInput = $_POST['userInput'];

            // Process the user input with the OpenAI Assistant API
            $thread_id = isset($_SESSION['thread_id']) ? $_SESSION['thread_id'] : null;
            if (empty($thread_id)) {
                $thread_id = $openai->create_thread($userInput);
                $_SESSION['thread_id'] = $thread_id;
            } else {
                $openai->add_message($thread_id, $userInput);
            }
            $openai->run_thread($thread_id);

            while ($openai->has_tool_calls) {
                $outputs = $openai->execute_tools($thread_id, $openai->tool_call_id);
                $openai->submit_tool_outputs($thread_id, $openai->tool_call_id, $outputs);
            }

            // Get and display the chatbot response
            $message = $openai->list_messages($thread_id);
            $message = $message[0];
            $output = '';
            if ($message['role'] == 'assistant') {
                foreach ($message['content'] as $msg) {
                    $output .= "{$msg['text']['value']}
";
                }
                echo '<script>document.getElementById("chat-messages").innerHTML += '<div><strong>Chatbot:</strong> ' . $output . '</div>';</script>';
            }
        }
    ?>