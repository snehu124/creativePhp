<style>
.container-fluid{
    margin: 10px 0;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    background-color: #ffffff;
    transition: box-shadow 0.3s, transform 0.2s;
    width: 100%;
}

.row{
    margin-left: 0 !important;
    margin-right: 0 !important;
}

/* Hover */
.container-fluid:hover{
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transform: translateY(-2px);
}

/* Question text */
.container-fluid h6{
    font-weight: 600;
    margin-bottom: 15px;
    margin-top: 0;
    color: #333;
    font-size: 16px;
    line-height: 1.5;
}

/* Options */
.option-box{
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.option-box label{
    padding: 10px 18px;
    border: 2px solid #6f42c1;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
    color: #6f42c1;
    transition: 0.3s;
}

.option-box input{
    display: none;
}

/* Selected */
.option-box input:checked + span{
    color: #fff;
    background: #6f42c1;
    padding: 10px 18px;
    border-radius: 10px;
}

/* Hover effect */
.option-box label:hover{
    background: #f3ecff;
}

/* 📱 Mobile Responsive */
@media (max-width: 768px){
    .container-fluid{
        width: 100%;
        padding: 12px 15px;
    }

    .option-box{
        flex-direction: column;
        gap: 10px;
    }

    .option-box label{
        width: 100%;
        text-align: center;
    }

    .container-fluid h6{
        font-size: 15px;
    }
}
</style>

<div class="container-fluid col-lg-12 col-md-12 col-sm-12">
    
    <h6><?= $char ?>. <?= htmlspecialchars($q['question_text']) ?></h6>
   
    <div class="option-box">
        <label>
            <input type="radio" name="answer[<?= $q['id'] ?>]" value="Primary">
            <span>Primary Source</span>
        </label>

        <label>
            <input type="radio" name="answer[<?= $q['id'] ?>]" value="Secondary">
            <span>Secondary Source</span>
        </label>
    </div>

</div>