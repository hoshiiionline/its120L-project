<?php
require '../config/config.php';
$title = "Data Privacy Policy";
include "../includes/header.php";
?>
<link rel="stylesheet" href="../css/returningCustomer.css">
<style>
  .scrollable-container {
    max-height: 70vh;
    overflow-y: scroll;
    padding: 20px;
    background: #fff;
    margin-bottom: 20px;
  }
  .scrollable-container h1,
  .scrollable-container h2,
  .scrollable-container p,
  .scrollable-container ul {
      width: 80%;
      justify-self: center;
  }

  ::-webkit-scrollbar {
      -webkit-appearance: none;
      width: 7px;
  }
  ::-webkit-scrollbar-thumb {
      border-radius: 4px;
      background-color: rgba(0, 0, 0, .3);
  }

  li {
    list-style-type: circle;
  }

  .scrollable-container p, li, h3{
      text-align: justify;
  }
  .scrollable-container h3 {
      padding-top: 1em;
      padding-left: 4em;
  }
  .scrollable-container p {
      tab-size 2;
  }
</style>
</head>
<body class="background1">
<div class="container">
    <div class="scrollable-container">
    <div><img src="../assets/logoflat.png" width="30%"></div>
          <h2>Data Privacy Policy</h2>
      <p style="text-align: center; color: gray"><em>Last Updated: March 1, 2025</em></p>
      <p>
          &emsp;&emsp;&emsp;This Data Privacy Policy explains how Banahaw Circle Nature Resort
        collects, uses, and safeguards your personal information when you visit our website
        and use our services. We are committed to protecting your privacy and ensuring that your
        personal data is handled in a safe and responsible manner.
      </p>
  
      <h3>1. Information We Collect</h3>
      <p>&emsp;&emsp;&emsp;We may collect and process the following types of personal information:</p>
      <ul>
        <li>Contact information such as your name, email address, and phone number;</li>
        <li>Account details including your username and password;</li>
        <li>Usage data, including pages visited, time spent on pages, and other statistics;</li>
        <li>Cookies and similar tracking technologies to improve your experience.</li>
      </ul>
  
      <h3>2. How We Use Your Information</h3>
      <p>&emsp;&emsp;&emsp;Your personal information is used for the following purposes:</p>
      <ul>
        <li>To provide, maintain, and improve our services;</li>
        <li>To communicate with you regarding your account or our services;</li>
        <li>To personalize your experience on our website;</li>
        <li>To comply with legal obligations and protect our rights.</li>
      </ul>
  
      <h3>3. Disclosure of Your Information</h3>
      <p>&emsp;&emsp;&emsp;We do not sell or share your personal information with third parties except under the following circumstances:</p>
      <ul>
        <li>To trusted service providers who assist us in operating our website and delivering our services, subject to confidentiality agreements;</li>
        <li>When required by law, regulation, or legal process;</li>
        <li>In connection with a merger, acquisition, or sale of assets.</li>
      </ul>
  
      <h3>4. Data Security</h3>
      <p>
          &emsp;&emsp;&emsp;We implement appropriate technical and organizational measures to protect your personal data from unauthorized access,
        alteration, disclosure, or destruction. While we strive to secure your information, no transmission over the internet or
        method of electronic storage is 100% secure.
      </p>
  
      <h3>5. Data Retention</h3>
      <p>
          &emsp;&emsp;&emsp;We will retain your personal information for as long as is necessary to fulfill the purposes outlined in this policy,
        unless a longer retention period is required or permitted by law.
      </p>
  
      <h3>6. Your Rights</h3>
      <p>
          &emsp;&emsp;&emsp;You have the right to access, update, correct, or delete your personal data. You may also have the right to restrict or object
        to certain data processing activities. To exercise your rights, please contact us using the details provided in the Contact section.
      </p>
  
      <h3>7. Changes to This Policy</h3>
      <p>
          &emsp;&emsp;&emsp;We may update this Data Privacy Policy from time to time. Any changes will be posted on this page with an updated effective date.
        Please review this policy periodically for any changes.
      </p>
  
      <h3>8. Contact Us</h3>
      <p>
          &emsp;&emsp;&emsp;If you have any questions, concerns, or requests regarding this Data Privacy Policy or our data practices, please contact us at:
      </p>
      <p>
        Banahaw Circle Nature Resort<br>
        #387 Holy Trinity Compound, Brgy. Sta Lucia, Dolores, Philippines<br>
        Email: <a href="mailto:banahawcircle@gmail.com">banahawcircle@gmail.com</a><br>
        Phone: 0962-325-5819
      </p>
    </div>
    
    <br>
    <div style="text-align:left">
      <a class="back" href="crm.php">< Back</a>
    </div>
</div>
<?php include "../includes/footer.php"; ?>
