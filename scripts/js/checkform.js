import { getUser } from './user.js';
export function signin() {
    const form = document.getElementById("signin_form");
    const idInput = document.getElementById("signin_id");
    const pwdInput = document.getElementById("signin_pwd");
    if (!idInput.value) {
        alert('아이디를 입력해주세요.');
        idInput.focus();
        return;
    }
    if (!pwdInput.value) {
        alert('비밀번호를 입력해주세요. ');
        pwdInput.focus();
        return;
    }
    form.submit();
}
export function signup() {
    // querySelector('#id');
    const form = document.getElementById("signup_form");
    const idInput = document.getElementById("signup_id");
    const pwdInput = document.getElementById("signup_pwd");
    const nameInput = document.getElementById("signup_name");
    const ageInput = document.getElementById("signup_age");
    if (!idInput.value) {
        alert('아이디를 입력해주세요.');
        idInput.focus();
        return;
    }
    if (!pwdInput.value) {
        alert('비밀번호를 입력해주세요. ');
        pwdInput.focus();
        return;
    }
    if (!nameInput.value) {
        alert('이름을 입력해주세요. ');
        nameInput.focus();
        return;
    }
    if (!ageInput.value) {
        alert('나이를 입력해주세요.');
        ageInput.focus();
        return;
    }
    if (!/^\d+$/.test(ageInput.value)) { // int regex
        alert('나이는 자연수로 입력해주세요.');
        ageInput.focus();
        return;
    }
    form.submit();
}
export function book() {
    const form = document.getElementById("book_form");
    const isbnInput = document.getElementById("add_isbn");
    const titleInput = document.getElementById("add_title");
    const authorInput = document.getElementById("add_author");
    const publisherInput = document.getElementById("add_publisher");
    if (!isbnInput.value) {
        alert('ISBN이 누락되었습니다.');
        return;
    }
    if (!/^\d{8,14}$/.test(isbnInput.value)) { // int regex
        alert('ISBN의 형식이 잘못되었습니다.');
        isbnInput.focus();
        return;
    }
    else if (!titleInput.value) {
        alert('제목이 누락되었습니다.');
        titleInput.focus();
        return;
    }
    else if (!authorInput.value) {
        alert('저자가 누락되었습니다. ');
        authorInput.focus();
        return;
    }
    else if (!publisherInput.value) {
        alert('출판사가 누락되었습니다.');
        publisherInput.focus();
        return;
    }
    form.submit();
}
export function checkoutReturn() {
    const form = document.querySelector('[name="bookForm"]');
    if (getUser() == null) {
        alert('로그인 정보가 없습니다.');
        return;
    }
    form.submit();
}
export function returnAll() {
    const form = document.querySelector("#myBooks");
    if (getUser() == null) {
        alert('로그인 정보가 없습니다.');
        return;
    }
    let checked = false;
    const checkboxes = document.querySelectorAll('[type="checkbox"]');
    for (const cb of checkboxes) {
        if (cb.checked)
            checked = true;
    }
    if (!checked) {
        alert('책을 선택해주세요.');
        return;
    }
    form.submit();
}
export function remove() {
    const ok = confirm('※경고! 정말로 이 책을 삭제하시겠습니까?');
    if (!ok) {
        return;
    }
    const urlParams = new URLSearchParams(window.location.search);
    const isbnParam = urlParams.get('isbn');
    if (isbnParam == null) {
        alert(`ISBN 처리에 문제가 발생했습니다.\nISBN: ${isbnParam}`);
        return;
    }
    location.href = `/db/delete.php?isbn=${isbnParam}`;
}
export function modify() {
    const ok = confirm('※책 정보를 수정하시겠습니까?');
    if (!ok) {
        return;
    }
    const urlParams = new URLSearchParams(window.location.search);
    const isbnParam = urlParams.get('isbn');
    if (isbnParam == null) {
        alert(`ISBN 처리에 문제가 발생했습니다.\nISBN: ${isbnParam}`);
        return;
    }
    location.href = `/db/update.php?isbn=${isbnParam}`;
}
export function search(event) {
    event.preventDefault();
    const search = document.querySelector("#searchBox").value;
    if (search == "") {
        alert("검색어를 입력해주세요.");
        return;
    }
    // SQL injection prevention
    if (['--', ';', '*'].some(s => search.includes(s))) {
        alert("입력할 수 없는 특수문자가 포함되어 있습니다.");
        return;
    }
    const encoded = encodeURIComponent(search);
    const option = document.querySelector('input[value="AND"]').checked ? "AND" : "OR";
    location.href = `/books/search.php?search=${encoded}&option=${option}`;
}
