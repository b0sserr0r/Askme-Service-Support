<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>

<div>
        <span id="loading">Loading</span>
        <div id=lineProfile>
            <img width="100px: src=">
            <div id="linename"> Hello Name </div>
            <div id="lineid"> UID: Your UID</div>


</div>
</div>

<script charset="utf-8" src="https://static.line-scdn.net/liff/edge/versions/2.22.3/sdk.js"></script>
<script>
    const main = async () => {
        await liff.init({ liffId: '2004935263-l7Ag04J4'})
     

        if(!liff.isLoggedIn())
        {
            
            liff.login()
            return false
            
        }
        else
        {
            const profile = await liff.getProfile()
            loading.style.display = 'none'
            linename.textContent = 'Hello ' + profile.displayName
            lineid.textContent = profile.userId
            console.log("is Loggin")
        }

    }

    main()
    </script>
</body>
</html>