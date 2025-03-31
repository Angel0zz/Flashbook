<?php include('./views/partials/head.php')?>
<?php include('./views/partials/nav.php')?>

<?php

$admin_result = $con->query("SELECT * FROM tb_admin");


$freelancer_result = $con->query("SELECT * FROM tb_freelancers Where Status ='Active'");

$chatId = isset($_GET['chatId']) ? intval($_GET['chatId']) : null;

$email = null;
if ($chatId) {
    $email_query = "
    SELECT role, NULL AS fname, NULL AS middle_name, NULL AS last_name 
    FROM tb_admin WHERE adminID = $chatId 
    UNION 
    SELECT NULL AS role, fname, middle_name, last_name 
    FROM tb_freelancers WHERE FchatId = $chatId
";

    $email_result = $con->query($email_query);
    
    if ($email_result && $email_result->num_rows > 0) {
        $email_row = $email_result->fetch_assoc();
        
        if (isset($email_row['role'])) {
            $email = "Admin";
        } else {
            $email = htmlspecialchars($email_row['fname'] . ' ' . $email_row['middle_name'] . ' ' . $email_row['last_name']);
        }
    }
}
?>

<div class="Msg-main-container">
    <div class="cht-bx-container">
        <div class="F-Container">
            <span style='font-size:25px; margin:auto; font-weight:500;'><span style ="color:#99CCFF;">Flashbook</span> Chat</span>
            <section class='Ttle'>Admin</section>
            <?php while ($admin = $admin_result->fetch_assoc()): ?>
                <div class="card" onclick="startConversation(<?= intval($admin['adminID']) ?>)">
                    <section class="profile"><img src="../assets/blank-profile-picture-973460_1280.png" alt=""></section>
                    <section class="cardDetails">
                        <div class="cardName">Admin</div>
                        <section class="text" style='font-size:10px;'>view Conversation</section>
                    </section>
                </div>
            <?php endwhile; ?>
            
            <section class='Ttle'>Freelancers</section>
            <?php while ($freelancer = $freelancer_result->fetch_assoc()): ?>
                <div class="card" onclick="startConversation(<?= intval($freelancer['FchatId']) ?>)">
                    <section class="profile"><img src="../assets/blank-profile-picture-973460_1280.png" alt=""></section>
                    <section class="cardDetails">
                        <div class="cardTitle">Freelancer</div>
                        <div class="cardName"><?= htmlspecialchars($freelancer['fname'] . ' ' . $freelancer['last_name']); ?></div>
                        <section class="text" style='font-size:10px;'>view Conversation</section>
                    </section>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="S-Container">
            <div class="headTitle" style='display:flex; align-items:center;font-size:20px;'>
            <div id="burger" style="cursor: pointer; margin-inline:10px;">
                &#9776; <!-- Unicode for burger icon -->
            </div>
                <?php if ($email): ?>
                    <span> <?= $email; ?></span>
                <?php else: ?>
                    <span>Select a conversation </span>
                <?php endif; ?>
            </div>
            <div id="chat-box" class='chat-box'></div>
            <div class="chatField">
                <input id="message-input" type="text" style='height:30px;'>
                <button onclick="sendMessage()">Send</button>
            </div>
        </div>
    </div>
</div>

<script>
    function startConversation(chatId) {
        window.location.href = `?chatId=${chatId}`;
    }

    function sendMessage() {
        const messageInput = document.getElementById("message-input");
        const message = messageInput.value.trim();
        const chatId = <?php echo json_encode($chatId); ?>;
        const userChatId = <?php echo json_encode($_SESSION['UchatId']); ?>;

        console.log(`chatId: ${chatId}, message: ${message}, userChatId: ${userChatId}`);

        if (message === "" || !chatId || !userChatId) {
            console.error("Invalid input: ", { message, chatId, userChatId });
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../php/client_send_message.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    messageInput.value = "";
                    loadMessages();
                } else {
                    alert("Failed to send message: " + xhr.status + " " + xhr.statusText);
                }
            }
        };

        xhr.send(`chatId=${chatId}&message=${encodeURIComponent(message)}&userChatId=${userChatId}`);
    }

    function loadMessages() {
        const chatId = <?php echo json_encode($chatId); ?>;
        const xhr = new XMLHttpRequest();
        xhr.open("GET", `../php/client_load_messages.php?chatId=${chatId}`, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                const chatBox = document.getElementById("chat-box");
                chatBox.innerHTML = xhr.responseText;

                // Delay the scroll to allow DOM rendering to complete
                setTimeout(function() {
                    chatBox.scrollTop = chatBox.scrollHeight;
                }, 100);
            }
        };
        xhr.send();
    }

    document.getElementById("message-input").addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); 
            sendMessage(); 
        }
    });

    window.onload = function() {
        loadMessages();
        setInterval(loadMessages, 2000); // Automatically reload messages every 2 seconds
    };


    document.getElementById("burger").addEventListener("click", function() {
    const fContainer = document.querySelector(".F-Container");
    if (fContainer.style.display === "none" || fContainer.style.display === "") {
        fContainer.style.display = "block"; // Show the container
    } else {
        fContainer.style.display = "none"; // Hide the container
    }
});
</script>

<?php include('./views/partials/footer.php')?>
