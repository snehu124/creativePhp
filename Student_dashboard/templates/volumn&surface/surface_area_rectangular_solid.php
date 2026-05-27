<style>

.surface-wrapper{
    width:100%;
    max-width:900px;
    margin:10px auto 25px;
    padding:0 10px;
}

.surface-heading{
    font-size:16px;
    font-weight:600;
    color:#222;
    margin-bottom:12px;
}

.q-label{
    font-weight:700;
    margin-right:6px;
}

.surface-row{
    display:flex;
    align-items:center;
    gap:20px;
}

/* REMOVE WHITE BOX */
.surface-image{
    width:260px;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-shrink:0;
}

.surface-image img{
    width:100%;
    height:auto;
    object-fit:contain;
    display:block;
}

/* ANSWER SECTION */
.surface-answer{
    flex:1;
}

/* ONE LINE ANSWER */
.answer-line{
    display:flex;
    align-items:center;
    gap:10px;
    width:100%;
}

.answer-label{
    font-size:18px;
    font-weight:600;
    color:#222;
    white-space:nowrap;
}

.answer-input{
    flex:1;
    min-width:180px;
    border:none;
    border-bottom:2px solid #1F669C;
    padding:4px;
    font-size:16px;
    outline:none;
    background:transparent;
}

.answer-input:focus{
    border-bottom-color:#007bff;
}

.unit-text{
    font-size:16px;
    font-weight:600;
    color:#333;
    white-space:nowrap;
}

/* MOBILE */
@media(max-width:600px){

    .surface-row{
        flex-direction:column;
        align-items:flex-start;
    }

    .surface-image{
        width:220px;
    }

    .answer-line{
        width:100%;
    }
}

</style>

<div class="surface-wrapper">

    <div class="surface-heading">
        <span class="q-label"><?= $h($question_label) ?>.</span>
        <?= $h($text_template) ?>
    </div>

    <div class="surface-row">

        <?php if($final_image_path !== ''): ?>
        <div class="surface-image">
            <img src="<?= $h($final_image_path) ?>" alt="Surface Area Question">
        </div>
        <?php endif; ?>

        <div class="surface-answer">

            <div class="answer-line">

                <span class="answer-label">
                    Surface Area =
                </span>

                <input
                    type="text"
                    class="answer-input"
                    id="surface_<?= (int)$q['id'] ?>"
                    name="answer[<?= (int)$q['id'] ?>]"
                >

                <?php if(!empty($data['unit'])): ?>
                    <span class="unit-text">
                        <?= $h($data['unit']) ?>
                    </span>
                <?php endif; ?>

            </div>

        </div>

    </div>

</div>