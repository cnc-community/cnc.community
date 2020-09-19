@extends('layouts.app')

@section('title', '25 Years of Command & Conquer')
@section('description', 'Celebrating 25 Years of Command & Conquer with a Prize Giveaway')
@section('page-class', 'anniversary')

@section('hero')
<div class="content center">
    <img src="/assets/images/cnc-25-years-logo.png" alt="C&C 25 Years" />
</div>
@endsection

@section('content')
<section class="section intro">
    <div class="main-content text-center">
        <h1 class="section-title">Celebrating 25 years <br class="hide-for-xs"/> of Command &amp; Conquer</h1>
        <p class="lead">
            Take a look below to see the events you can take part in! <br class="hide-for-xs"/>
            Prizes will be given out just for playing online!
        </p>

        <div class="logos">
            <div>
                <img src="assets/images/logos/red-alert-remastered.png" alt="Red Alert Remastered Logo" />
            </div>
            <div>
                <img src="assets/images/logos/tiberian-dawn-remastered.png" alt="Tiberian Dawn Remastered Logo" />
            </div>
        </div>
    </div>
</section>

<section class="section dates">
    <div class="main-content text-center">
        <p class="lead">
            Event Start: <strong>24th September</strong> <em>6PM (BST)</em>
        </p>
        <p class="lead">
            Event Ends: <strong>27th September</strong> <em>6PM (BST)</em>
        </p>
        <p>
            Prizes will be given away EVERY day during this time. <br/> Anyone can win a prize regardless of their skill level!
        </p>
    </div>
</section>

<section class="section events">
    <div class="main-content text-center">
        <div class="event-boxes">
            <div class="event-box">
                <h2 class="text-uppercase">Just Play!</h2>
                <p>
                    For a chance to win a random prize, play online the Remastered Collection;
                    Tiberian Dawn or Red Alert during the event.  Play Ranked or Non Ranked games, it’s up to you!
                </p>
            </div>
            <div class="event-box">
                <h2 class="text-uppercase">Leaderboard</h2>
                <p>
                    Finish Rank #1 on <a href="/command-and-conquer-remastered/leaderboard/red-alert">Red Alert</a> 
                    or <a href="/command-and-conquer-remastered/leaderboard/tiberian-dawn">Tiberian Dawn</a> when the event ends and you will win a 1 year 
                    EA Play subscription. If you finish in the top 50, you will be put into a randomizer for a chance to win a prize too!
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section prizes">
    <div class="main-content text-center">
        <h2 class="text-uppercase">Prizes</h2>
        <p class="lead">
            We have lots of goodies to give away.
            You could be winning a Month long EA Play Subscription or a Year long EA Play Subscription code 
            Other prizes include Steam Gift Cards (Value £4).
        </p>
       
        <div class="prize-boxes">
            <div>
                <img src="assets/images/ea-play-prize.jpg" alt="EA Play" />
            </div>
            <div>
                <img src="assets/images/steam-prize.jpg" alt="Steam Gift Card" />
            </div>
        </div>
    </div>
</section>

<section class="section sponsors">
    <div class="main-content text-center">
        <h2 class="text-uppercase">Sponsors</h2>
       
        <div class="sponsor-logos">
            <div class="ea">
                <img src="assets/images/logos/ea.png" alt="EA" />
            </div>
            <div class="cnc-community">
                <img src="assets/images/logo.svg" alt="C&C Community" />
            </div>
        </div>
    </div>
</section>

<section class="section terms">
    <div class="main-content text-center">
        <div class="page-content">
            <h2 class="text-uppercase text-center">Terms &amp; Conditions</h2>
            <p>
                These terms apply to the C&C 25th Annivesary hosted by the C&C Community website. 
            </p>
            <p>
                <strong>Eligibility</strong> <br/>
                The event is open to Steam players only, playing Tiberian Dawn Remastered and Red Alert Remastered Online games.  
                Single player games will not qualify.
            </p>
            <p>
                <strong>Winner selection</strong> <br/>
                In order to qualify and be in for a chance of being picked for a prize, you must play during the event specified dates.  
                Winners of the "Just play event" where random prizes are awarded to players, will be picked by a random generator. 
                Winners of the "Leaderboard event" must finish Rank #1 by the event close date and time.
            </p>
            <p>
                The C&C Community site reserves the right to withhold awarding prizes to any player that violates any of the following conditions;  
                violating any EAUA Remastered terms and conditions as <a href="https://store.steampowered.com//eula/1213210_eula_0" target="_blank">listed here</a>,
                in addition if not explicitly stated; cheating or conducting foul play of any kind, harassment or abuse of other players. 
            </p>

            <p>
                Players are only able to win a maximum of 2 small band prizes, and a maximum of 1 large band prize during the event.
            </p>

            <p>
                Smaller band prizes include but are not limited to: Steam Gift Cards, 1 Month EA Play Subscription codes.
                Larger band prizes include but are not limited to: 1 Year EA Play Subscription codes.
            </p>

            <p>
                <strong>
                    Winners being contacted
                </strong> <br/>
                Prizes will be awarded to Steam Players only.  Players who have won, will have their steam username listed on the C&C community website as a winner. 

                The winners Steam account will then be added as a friend by a member of the C&C Community website team. If for whatever reason, their steam profile does not allow this, the players will not be eligible for a prize. 

                Upon sending a request and accepting, they will be asked to confirm they are able to accept the prize as the account holder, including that they are the account holder and of age in accordance to the Command & Conquer:tm: Remastered Collection EULA terms and conditions.
            </p>

            <p>
                Players who have won a prize, will have 14 days from the point of initially being contacted via Steam to accept the friend request and claim their prize. If after this period no contact is made, the player will lose their prize.
            </p>
            
            <p>
                EA has no affiliation to the C&C Community website and is soley donating prizes to this event in good spirit of the C&C Anniversary. 
                This is a community run event and thus EA are not responsible for this event. 
            </p>
            <p>
                In the extremely rare occasion prizes are withdrawn from the C&C Community teams possession, we will not be able to honor the delivery of prizes to winners.
            </p>
        </div>
    </div>
</section>
@endsection