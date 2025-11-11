  <style>
    li {
        padding: 5px !important;
    }

    .btn-success {
        background-color: #1c84c6;
        border-color: #1c84c6;
        color: #FFFFFF;
        margin-left: 200px;
        padding: 10px 20px;
        font-weight: 600;
    }

    .btn:not(:disabled):not(.disabled) {
        cursor: pointer;
    }

    .btn-primary:hover {
        color: #fff;
        background-color: #1b8eb7;
        border-color: #1985ac;
    }

    .btn-primary {
        color: #fff;
        background-color: #20a8d8;
        border-color: #20a8d8;
    }

    .btn:hover,
    .btn:focus {
        text-decoration: none;
    }

    .btn {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        user-select: none;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    /* .titlebox {
        font-size: 22px;
        font-weight: bold;
        text-align: center;
        margin-top: 20px;
    } */

    /* .contentarea {
        max-width: 600px;
        margin: auto;
        padding: 20px;
    } */

    ul {
        padding-left: 30px;
    }

    /* Mobile responsiveness */
    /* @media (max-width: 600px) {
        .btn-success {
            margin-left: 0;
            width: 100%;
            box-sizing: border-box;
        }

        .btn {
            width: 100%;
            font-size: 1rem;
        }

        .titlebox {
            font-size: 20px;
            padding: 10px;
        }

        .contentarea {
            padding: 10px;
        }

        h3 {
            font-size: 13px;
        }

        ul {
            padding-left: 20px;
        }

        p {
            margin-left: 0 !important;
        }
    } */
</style>
<div class="titlebox">
    Survey is not Live
</div>
<div class="contentarea">
   <h3 style="font-size: 14px;text-align:center;">
   <strong>
    Oops… you’re a little late! This survey has now closed. Click the button below to explore another survey.
 
   </strong>
   
    <p style="text-align: center;"><a href="{{url('dashboard')}}" title="Take Another Survey"><button class="btn btn-primary">Take another survey</button></a></p>
    <p style="padding-bottom:15px; text-align:center">
	To report a problem or share feedback, please write to us at <a href="mailto:support@sjpanel.com">support@sjpanel.com</a> 

	</p>
    <div id="countdown" style="text-align:center;"></div>
</div>