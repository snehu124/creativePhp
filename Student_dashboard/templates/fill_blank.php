<?php
$payload = json_decode($q['question_payload'] ?? '', true) ?: [];
$isPieChart = ($payload['type'] ?? '') === 'pie_chart';

if (!isset($GLOBALS['pie_image_shown'])) {
    $GLOBALS['pie_image_shown'] = false;
}
?>
<style>
/* Container spacing and styling */
.container-fluid {
    margin: 10px auto;  
    padding: 15px 20px; 
    border-radius: 12px; 
    box-shadow: 0 2px 6px rgba(0,0,0,0.1); 
    background-color: #ffffff; 
    transition: 0.3s;
    width: 100%;
    max-width: 900px;   
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

/* ✅ image styling */
.question-img {
    text-align: center;
    margin-bottom: 15px;
}
.question-img img {
    max-width: 100%;
    border-radius: 10px;
}

.pie-chart-banner {
    width: 100%;
    text-align: center;
    margin-bottom: 25px;
}

.pie-chart-banner img {
    max-width: 600px;
    width: 100%;
    height: auto;
    border-radius: 0;
    box-shadow: none;
}
</style>
<!-- ✅ IMAGE OUTSIDE CARD -->
<?php if ($isPieChart && !$GLOBALS['pie_image_shown'] && !empty($q['question_image'])): ?>
    
    <div class="pie-chart-banner">
        <img src="<?= htmlspecialchars($q['question_image']) ?>">
    </div>

    <?php $GLOBALS['pie_image_shown'] = true; ?>

<?php endif; ?>

<!-- ✅ CARD START -->
<div class="container-fluid col-lg-12 col-sm-12 col-md-12">

    <h6><?= $char.'. '. htmlspecialchars($q['question_text']) ?></h6>
    <?php $char++; ?>

    <input type="text"
        class="quiz-input"
        name="answer[<?= $q['id'] ?>]"
        placeholder="Type your answer here"/>

</div>

<script>
document.addEventListener("DOMContentLoaded", function(){

    document.querySelectorAll(".quiz-input").forEach(function(input){

        input.addEventListener("blur", function(){

            let val = input.value;

            // ✅ remove extra spaces around commas
            val = val.split(",")
                     .map(v => v.trim())
                     .filter(v => v !== "")
                     .join(",");

            // ✅ convert to proper format (capitalize words)
            val = val.replace(/\b\w/g, c => c.toUpperCase());

            input.value = val;
        });

    });

});
</script>