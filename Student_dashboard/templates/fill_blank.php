<style>
/* Container spacing and styling */
.container-fluid {
    margin-left: 50px;
    margin-bottom: 20px;
    padding: 15px 20px; 
    border-radius: 12px; 
    box-shadow: 0 2px 6px rgba(0,0,0,0.1); 
    background-color: #ffffff; 
    transition: box-shadow 0.3s, transform 0.2s;
    width: 90%;
    margin-top:10px;
}

/* Hover effect for subtle lift */
.container-fluid:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transform: translateY(-2px);
}

/* Question text */
.container-fluid h6 {
    font-weight: 600;
    margin-bottom: 10px; 
    margin-top: 0;
    color: #333; 
}

/* Input field design (bottom border full width) */
.quiz-input {
    width: 100%; /* Full container width */
    padding: 8px 0; /* Top & bottom padding */
    font-size: 16px;
    border: none;
    border-bottom: 2px solid #ccc; /* Full-width bottom border */
    outline: none;
    background-color: transparent; 
    transition: border-color 0.3s;
}

/* Input focus effect */
.quiz-input:focus {
    border-bottom-color: #007bff; 
}
</style>

<div class="container-fluid col-lg-12 col-sm-12 col-md-12">
    <h6><?= $char.'. '. htmlspecialchars($q['question_text']) ?></h6>
    <?php $char++; ?>
    <input type="text" class="quiz-input" name="answer[<?= $q['id'] ?>]" placeholder="Type your answer here"/> 
</div>
