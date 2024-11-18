let baseJSON = {
    "area": "",
    "definicion": "",
    "base": "",
    "opciones": [
        { "texto": "", "valor": "incorrecta", "argumentacion": "" },
        { "texto": "", "valor": "incorrecta", "argumentacion": "" },
        { "texto": "", "valor": "incorrecta", "argumentacion": "" },
        { "texto": "", "valor": "incorrecta", "argumentacion": "" }
    ],
    "imagen": ""
};

let correctAnswers = 0;

function deleteQuestion(id) {
    if (confirm("¿Estás seguro de que deseas eliminar este reactivo?")) {
        $.post(`../src/question-delete.php`, { id: id }, function(response) {
            try {
                response = typeof response === "string" ? JSON.parse(response) : response;
                console.log("Parsed response:", response);

                if (response.status === 'success') {
                    fetchQuestions(); 
                    alert('Reactivo eliminado con éxito.');
                } else {
                    alert('Error al eliminar el reactivo: ' + response.message);
                }
            } catch (error) {
                console.error("JSON parsing error:", error);
                alert('Error al eliminar el reactivo.');
            }
        }).fail(function(xhr, status, error) {
            console.error('AJAX error:', status, error);
            alert('Error al enviar la solicitud.');
        });
    }
}

function editQuestion(id) {
    window.location.href = `edit-questions.php?id=${id}`;
}

function fetchQuestions() {
    $.ajax({
        url: '../src/fetch-questions.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.status === 'success' && Array.isArray(data.questions)) {
                const tableBody = $('#questionsTable tbody');
                tableBody.empty();

                data.questions.forEach(question => {
                    const row = `
                        <tr>
                            <td class="d-none">${question.id}</td>
                            <td>${question.area}</td>
                            <td>${question.definicion}</td>
                            <td>${question.base}</td>
                            <td class="text-center button-td">
                                <button class="btn btn-warning me-2" onclick="editQuestion(${question.id})">Editar</button>
                                <button class="btn btn-danger" onclick="deleteQuestion(${question.id})">Borrar</button>
                            </td>
                        </tr>
                    `;
                    tableBody.append(row);
                });
            } else {
                console.error("Unexpected response format:", data);
                alert("No questions available.");
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching questions:', error);
            console.error('Response Text:', xhr.responseText); 
            alert("An error occurred while fetching questions.");
        }
    });
}



const questionForm = document.querySelector("#question-form");
if (questionForm) {
    questionForm.addEventListener("submit", function(event) {
        if (!validateForm()) {
            event.preventDefault(); 
            alert("Por favor, completa todos los campos y asegúrate de que solo una opción esté marcada como 'Correcta'.");
        }
    });
}


function validateForm() {
    let isValid = true;

    const inputs = document.querySelectorAll("#question-form input[type='text'], #question-form textarea");
    inputs.forEach(input => {
        if (input.value.trim() === "") {
            isValid = false;
            input.classList.add("is-invalid");
        } else {
            input.classList.remove("is-invalid");
        }
    });

    const selects = document.querySelectorAll("#question-form select");
    let correctCount = 0;
    selects.forEach(select => {
        if (select.value === "correcta") {
            correctCount++;
        }
    });

    if (correctCount !== 1) {
        isValid = false;
    }

    return isValid;
}

$(document).ready(function() {
    let questionsArray = []; 

    console.log('Script isrve');
    init();

    function init() {
        var baseJSON = {
            "area": "",
            "definicion": "",
            "base": "",
            "opciones": [
                { "texto": "", "valor": "incorrecta", "argumentacion": "" },
                { "texto": "", "valor": "incorrecta", "argumentacion": "" },
                { "texto": "", "valor": "incorrecta", "argumentacion": "" },
                { "texto": "", "valor": "incorrecta", "argumentacion": "" }
            ],
            "imagen": ""
        };

        var JsonString = JSON.stringify(baseJSON, null, 2);
        $('#description').val(JsonString);
    }

    const imageUploadInput = document.getElementById('imageUpload');
    if (imageUploadInput) {
        imageUploadInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    baseJSON.imagen = e.target.result;
                    console.log("Imagen subida y encoded.");
                }
                reader.readAsDataURL(file);
            }
        });
    }

    $('#question-form').submit(function(e) {
        e.preventDefault();

        let finalJSON = {
            "area": $('#area').val().trim(),
            "definicion": $('#definicion').val().trim(),
            "base": $('#base').val().trim(),
            "opciones": []
        };

        for (let i = 1; i <= 4; i++) {
            finalJSON.opciones.push({
                "texto": $(`input[name="opcion_${i}"]`).val().trim(),
                "valor": $(`select[name="op${i}_value"]`).val(),
                "argumentacion": $(`textarea[name="arg_${i}"]`).val().trim()
            });
        }

        finalJSON.imagen = baseJSON.imagen || "";

        if (!finalJSON.area || !finalJSON.definicion || !finalJSON.base) {
            alert('Todos los campos principales son obligatorios.');
            return;
        }

        console.log(finalJSON);

        let url = '../src/question-add.php';
        $.post(url, JSON.stringify(finalJSON), function(response) {
            let resp = JSON.parse(response);
            let template = `
                <li style="list-style: none;">status: ${resp.status}</li>
                <li style="list-style: none;">message: ${resp.message}</li>
            `;
            $('#question-result').show();
            $('#container').html(template);
            $('#question-form').trigger('reset');
            init();
        }).fail(function(jqXHR, textStatus, errorThrown) {
            alert('Error al enviar la solicitud: ' + errorThrown);
        });
    });

    $('#edit-question').submit(function(e) {
        e.preventDefault();
    
        let finalJSON = {
            "area": $('#area').val().trim(),
            "definicion": $('#definicion').val().trim(),
            "base": $('#base').val().trim(),
            "opciones": []
        };
    
        finalJSON.opciones = [];
    
        $('.row .col-md-6').each(function() {
            let id = $(this).find('input[type="text"]').attr('name').match(/\d+/)[0];
    
            finalJSON.opciones.push({
                "texto": $(`input[name="opcion_${id}"]`).val().trim(),
                "valor": $(`select[name="op${id}_value"]`).val(),
                "argumentacion": $(`textarea[name="arg_${id}"]`).val().trim()
            });
        });
    
        finalJSON.imagen = baseJSON.imagen || "";
    
        if (!finalJSON.area || !finalJSON.definicion || !finalJSON.base) {
            alert('Todos los campos principales son obligatorios.');
            return;
        }
    
        console.log(finalJSON);
    
        const urlParams = new URLSearchParams(window.location.search);
        const questionId = urlParams.get('id');
    
        let url = `../src/question-edit.php?id=${questionId}`;
    
        $.post(url, JSON.stringify(finalJSON), function(response) {
            let resp = JSON.parse(response);
            let template = `
                <li style="list-style: none;">status: ${resp.status}</li>
                <li style="list-style: none;">message: ${resp.message}</li>
            `;
            $('#question-result').show();
            $('#container').html(template);
            init();
        }).fail(function(jqXHR, textStatus, errorThrown) {
            alert('Error al enviar la solicitud: ' + errorThrown);
        });
    });
    
    $(document).ready(function() {
        fetchQuestions();
    });

    $(document).ready(function() {
        let questions = [];
        let currentQuestionIndex = 0;
        const userResponses = [];
        const questionAmount = new URLSearchParams(window.location.search).get('question-amount');
    
        $.get('../src/generate-exam.php', { 'amount': questionAmount })
            .done(function(data) {
                questions = data.questions;
                console.log("Fetched questions:", questions);
                displayQuestion(currentQuestionIndex);
            })
            .fail(function(error) {
                console.error('Error fetching questions:', error);
            });
    
        function displayQuestion(index) {
            if (index < 0 || index >= questions.length) return;
    
            const question = questions[index];
            const questionText = $('#question-text');
            const optionsContainer = $('#respuestas');
    
            console.log(`Displaying question ${index + 1}:`, question);
    
            questionText.text(question.base);
    
            optionsContainer.empty();
            question.options.forEach(option => {
                const optionHtml = `
                    <label>
                        <input type="radio" name="question_${question.id}" value="${option.id}" 
                        ${isSelected(question.id, option.id) ? 'checked' : ''} required>
                        ${option.texto_opcion}
                    </label><br>
                `;
                optionsContainer.append(optionHtml);
            });
    
            $(`input[name="question_${question.id}"]`).on('change', function() {
                const selectedValue = parseInt($(this).val());
                console.log(`Selected option for question ${question.id}:`, selectedValue);
                saveResponse(question.id, selectedValue);
            });
    
            const previousButton = $('#previous-question');
            const nextButton = $('#next-question');
    
            if (index === 0) previousButton.hide();
            else previousButton.show();
    
            if (index === questions.length - 1) nextButton.hide();
            else nextButton.show();
        }
    
        function isSelected(questionId, optionId) {
            const response = userResponses.find(response => response.id === questionId);
            return response && response.selected === optionId;
        }
    
        function saveResponse(questionId, selectedValue) {
            const existingResponse = userResponses.find(response => response.id === questionId);
    
            if (existingResponse) {
                existingResponse.selected = selectedValue;
                console.log(`Updated response for question ${questionId}:`, existingResponse);
            } else {
                userResponses.push({ id: questionId, selected: selectedValue });
                console.log(`Saved new response for question ${questionId}:`, selectedValue);
            }
    
            console.log("Current responses:", userResponses);
        }
    
        $('#next-question').click(function() {
            if (currentQuestionIndex < questions.length - 1) {
                currentQuestionIndex++;
                console.log("Navigating to next question:", currentQuestionIndex);
                displayQuestion(currentQuestionIndex);
            }
        });
    
        $('#previous-question').click(function() {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--;
                console.log("Navigating to previous question:", currentQuestionIndex);
                displayQuestion(currentQuestionIndex);
            }
        });
    
        $('#submit-exam').click(function() {
            let correctAnswers = 0;
        
            console.log("Submitting exam with responses:", userResponses);
        
            const results = [];
            userResponses.forEach(response => {
                const question = questions.find(q => q.id === response.id);
                
                console.log("Processing question:", question);
        
                if (!question) {
                    console.warn(`Question with ID ${response.id} not found!`);
                    return;
                }
        
                const selectedOption = question.options.find(option => option.id == response.selected);
                const correctOption = question.options.find(option => option.correct == 1);
                
                console.log("Selected Option:", selectedOption);
                console.log("Correct Option:", correctOption);
        
                const isCorrect = selectedOption && correctOption && parseInt(selectedOption.id) === parseInt(correctOption.id);
                if (isCorrect) correctAnswers++;
        
                results.push({
                    questionText: question.base,
                    selectedAnswer: selectedOption ? selectedOption.texto_opcion : 'No answer selected',
                    correctAnswer: correctOption ? correctOption.texto_opcion : 'undefined',
                    justification: correctOption && correctOption.justificacion ? correctOption.justificacion : 'No justification available',
                    isCorrect
                });
            });
        
            console.log("Final score:", correctAnswers, "out of", questions.length);
            console.log("Results data:", results);
        
            const resultData = {
                score: correctAnswers,
                totalQuestions: questions.length,
                results: results
            };
        
            window.location.href = `exam-results.php?data=${encodeURIComponent(JSON.stringify(resultData))}`;
        });
        
    });
    
    
    
});
