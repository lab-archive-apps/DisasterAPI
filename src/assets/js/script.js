'use strict';

/* Print Alert if push delete button. */
const deleteBtnGroup = document.querySelectorAll('.delete-btn');

for(let deleteBtn of deleteBtnGroup){
    if(!Object.is(deleteBtn, null)){
        deleteBtn.addEventListener('click', (e) => {
            if(!window.confirm('本当に削除しますか？')) {
                e.preventDefault();
            }
        });
    }
}

/* Form control function on "lists" */
const list = {
    currentNum: 0,
    template:   '<div class="field-body">' +
                    '<input type="text" name="list[_count_][message]" class="input" id="list_name__count_" placeholder="内容" required />' +
                '</div>',
    add: (e) => {
        if(list.currentNum >= 9){ alert('これ以上追加できません．'); return; }
        list.currentNum++;
        let newItem = list.template.replace(/_count_/mg, list.currentNum.toString());

        let newField = document.createElement("div");
        newField.setAttribute("class", "field is-horizontal");
        newField.innerHTML = newItem;

        let formArea = document.querySelector("section.section form");
        formArea.insertBefore(newField, formArea.querySelector('br'));
    },
    remove: (e) => {
        if (list.currentNum === 0) return;
        let formArea = document.querySelector('section.section form');
        formArea.removeChild(formArea.querySelector('br').previousElementSibling);
        list.currentNum--;
    }
};


const listAddBtn = document.getElementById('list-add-btn');
const listRemoveBtn = document.getElementById('list-remove-btn');

if(!Object.is(listAddBtn, null) && !Object.is(listRemoveBtn, null)) {
    listAddBtn.addEventListener('click', list.add);       // add
    listRemoveBtn.addEventListener('click', list.remove); // remove
}


/* Form control on "Prevention plan". */
const plan = {
    currentNum: 0,
    template:       '<div class="card-content">' +
                        '<div class="field is-horizontal">' +
                            '<div class="field-label is-normal"><label class="label" for="plan_title__count_">タイトル</label></div>' +
                            '<div class="field-body"><input type="text" name="plan[_count_][title]" id="plan_title__count_" class="input" placeholder="タイトル" required /></div>' +
                        '</div>' +
                        '<div class="field is-horizontal">' +
                            '<div class="field-label is-normal"><label class="label" for="plan_phase__count_">時期</label></div>' +
                            '<div class="field-body">' +
                                '<div class="select">' +
                                    '<select id="plan_phase__count_" name="plan[_count_][phase]" required>' +
                                        '<option disabled selected></option>' +
                                        '<option>災害発生前</option>' +
                                        '<option>災害発生直後</option>' +
                                        '<option>災害発生後</option>' +
                                        '<option>復旧/復興</option>' +
                                    '</select>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                        '<div class="field is-horizontal">' +
                            '<div class="field-label is-normal"><label class="label" for="plan_datetime__count_">日時</label></div>' +
                            '<div class="field-body">' +
                                '<input type="date" name="plan[_count_][s_date]" id="plan_start__count_" class="input" placeholder="開始日時" required />' +
                                '<input type="date" name="plan[_count_][e_date]" id="plan_end__count_" class="input" placeholder="終了日時" required />' +
                            '</div>' +
                        '</div>' +
                        '<br>' +
                        '<div class="field is-horizontal">' +
                            '<div class="field-label is-normal"></div>' +
                            '<div class="field-body">' +
                                '<textarea class="textarea is-medium" name="plan[_count_][content]" type="text" placeholder="概要"></textarea>' +
                            '</div>' +
                        '</div>' +
                    '</div>',
    add: (e) => {
        if(plan.currentNum >= 4){ alert('これ以上追加できません．'); return; }
        plan.currentNum++;
        let newItem = plan.template.replace(/_count_/mg, plan.currentNum.toString());

        let newField = document.createElement("div");
        newField.setAttribute("class", "card");
        newField.innerHTML = newItem;

        let formArea = document.querySelector("section.section form");
        formArea.insertBefore(newField, formArea.querySelector('br.node'));
    },
    remove: (e) => {
        if (plan.currentNum === 0) return;
        let formArea = document.querySelector('section.section form');
        formArea.removeChild(formArea.querySelector('br').previousElementSibling);
        plan.currentNum--;
    }
};

const planAddBtn = document.getElementById('plan-add-btn');
const planRemoveBtn = document.getElementById('plan-remove-btn');

if(!Object.is(planAddBtn, null) && !Object.is(planRemoveBtn, null)) {
    planAddBtn.addEventListener('click', plan.add);       // add
    planRemoveBtn.addEventListener('click', plan.remove); // remove
}

/* File upload on correspond records. */
const correspond = {
    upload: (e) => {
        const files = e.target.files; // FileList object
        for (let i = 0, file; file = files[i]; i++) {
            const fileBox = document.querySelector('.file');
            const icon = fileBox.querySelector('span.file-icon i');
            const label = fileBox.querySelector('span.file-label');
            const name = fileBox.querySelector('span.file-name');

            fileBox.classList.add('is-success');
            icon.classList.remove('fa-upload');
            icon.classList.add('fa-check-square-o');
            label.innerHTML = 'uploaded!';
            name.innerHTML = file.name;
        }
    }
};

const correspondFile = document.getElementById('correspond_file');

if(!Object.is(correspondFile, null)){
    correspondFile.addEventListener('change', correspond.upload);
}