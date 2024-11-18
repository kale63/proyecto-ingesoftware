$(document).ready(function() {
    const urlParams = new URLSearchParams(window.location.search);
    const dataString = urlParams.get('data');
    if (!dataString) {
        console.error("No data found in URL");
        return;
    }

    const data = JSON.parse(decodeURIComponent(dataString));
    console.log("Loaded data from URL:", data);

    $('#score').text(`Tu calificación: ${data.score} de ${data.totalQuestions}`);

    const resultsContainer = $('#results');
    if (resultsContainer.length === 0) {
        console.error("Results container not found!");
        return;
    }

    data.results.forEach((result, index) => {
        console.log(`Displaying result for question ${index + 1}:`, result);

        const questionText = result.questionText || 'Question text not available';
        const selectedAnswer = result.selectedAnswer || 'No answer selected';
        const correctAnswer = result.correctAnswer && result.correctAnswer !== 'undefined' ? result.correctAnswer : 'No correct answer available';
        const justification = result.justification || 'No hay justificación disponible :[';
        const isCorrect = result.isCorrect ? 'Correcta' : 'Incorrecta';

        const resultHtml = `
            <div class="result-item card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pregunta ${index + 1}</h5>
                    <p><strong>Pregunta:</strong> ${questionText}</p>
                    <p><strong>Tu Respuesta:</strong> ${selectedAnswer}</p>
                    <p><strong>Respuesta Correcta:</strong> ${correctAnswer}</p>
                    <p><strong>Justificación:</strong> ${justification}</p>
                    <p><strong>Resultado:</strong> <span class="${isCorrect === 'Correcta' ? 'text-success' : 'text-danger'}">${isCorrect}</span></p>
                </div>
            </div>
        `;

        resultsContainer.append(resultHtml);
    });
});
