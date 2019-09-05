(function() {
  var firebaseConfig = {
    apiKey: "AIzaSyCaoF4EMIixe1Jp0dWV5RM_UMacV46WML4",
    authDomain: "nextoponlinejudge-52748.firebaseapp.com",
    databaseURL: "https://nextoponlinejudge-52748.firebaseio.com",
    projectId: "nextoponlinejudge-52748",
    storageBucket: "",
    messagingSenderId: "600733822228",
    appId: "1:600733822228:web:1cc9343fdf7b802c"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);

  const txtEmail = document.getElementById('login_field');
  const txtPass = document.getElementById('password');
  const checkBtn = document.getElementById('commit');
  const checkLink = document.getElementById('join');

  checkBtn.addEventListener('submit', e => {
    const email = txtEmail.value;
    const pass = txtPass.value;
    const auth = firebase.auth();

    const promise = auth.signInWithEmailAndPassword(email, pass);
    promise.catch(e => console.log(e.message));
  });

  checkLink.addEventListener('click', e => {
    const email = txtEmail.value;
    const pass = txtPass.value;
    const auth = firebase.auth();

    const promise = auth.createUserWithEmailAndPassword(email, pass);
    promise.catch(e => console.log(e.message));
  });

  firebase.auth().onAuthStateChanged(firebaseUser => {
    if (firebaseUser) {
      console.log(firebaseUser);
      alert('가입을 환영합니다!');
    } else {
      console.log('not login');
      alert('중복된 계정이 있습니다.')
    }
  });
}());
