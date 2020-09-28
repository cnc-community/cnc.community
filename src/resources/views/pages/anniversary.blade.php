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
            Prizes will be given out just for playing online! <br class="hide-for-xs"/>
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

<section class="section winners sponsors">
    <div class="main-content text-center">
        <h2 class="text-uppercase">Winners</h2>
        <p>
            Congratulations to all the winners! <br class="hide-for-xs"/> 
            If your name is listed below, be sure to accept a Steam or <br class="hide-for-xs"/> Origin friend request from "neogrant" in order to receive your prize. 
        </p>

        <?php foreach($winners as $day => $playersWon): ?>
            <div class="day">
                <h3>Winners for <?php echo $day; ?></h3>
                <div class="names">
                    <?php foreach($playersWon as $player):?>
                    
                    <div class="name">
                        <h4><?php echo $player->name();?></h4>
                        <p>Won a <?php echo $player->prize(); ?>!</p>
                    </div>

                    <?php endforeach; ?>
                </div>
            </div>    
        <?php endforeach; ?>
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
                    EA Play Pro subscription. If you finish in the top 50, you will be put into a randomizer for a chance to win a prize too!
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
            You could be winning a Month long EA Play Pro Subscription or a Year long EA Play Pro Subscription code.
            Other prizes include Steam Gift Cards (Value £4).
        </p>
       
        <div class="prize-boxes">
            <div>
                <img src="assets/images/ea-play-prize.jpg" alt="EA Play Pro" />
            </div>
            <div>
                <img src="assets/images/steam-prize.jpg" alt="Steam Gift Card" />
            </div>
        </div>

        <div class="about-prizes">
            <h2 class="text-uppercase">EA Play Pro</h2>
            <p>
                EA Play Pro members can play the deluxe editions of every new Electronic Arts title -- with all the added extras including in-game rewards, Season Passes, and premium player content that lets you stand out from the competition – as soon as they drop. Plus, members have instant access to The Play List, a library of our fan-favorite series and best loved titles.
            </p>
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
                The event is open to Steam &amp; Origin players, playing Tiberian Dawn Remastered and Red Alert Remastered Online games.  
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
                Smaller band prizes include but are not limited to: Steam Gift Cards, 1 Month EA Play Pro Subscription codes.
                Larger band prizes include but are not limited to: 1 Year EA Play Pro Subscription codes.
            </p>

            <p>
                <strong>
                    Winners being contacted
                </strong> <br/>
                Prizes will be awarded to Steam and Origin Players.  Players who have won, will have their Steam or Origin username listed on the C&C community website as a winner. 

                The winners Steam or Origin account will then be added as a friend by a member of the C&C Community website team. If for whatever reason, the winners profile does not allow this, the players will not be eligible for a prize. 

                Upon sending a request and accepting, they will be asked to confirm they are able to accept the prize as the account holder and are of age in accordance to the Command & Conquer:tm: Remastered Collection EULA terms and conditions.
            </p>

            <p>
                Players who have won a prize, will have 14 days from the point of initially being contacted to accept the friend request and claim their prize. If after this period no contact is made, the player will lose their prize.
            </p>
            
            <p>
                EA has no affiliation to the C&C Community website and is soley donating prizes to this event in good spirit of the C&C Anniversary. 
                This is a community run event and thus EA are not responsible for this event. 
            </p>
            <p>
                In the extremely rare occasion prizes are withdrawn from the C&C Community teams possession, we will not be able to honor the delivery of prizes to winners.
            </p>

            <p>
                * THIS OFFER IS BEING ISSUED TO YOU FOR PROMOTIONAL PURPOSES ONLY AND DOES NOT HAVE A CASH VALUE.  SINGLE-USE CODE EXPIRES ON [09/24/2021]. CODE VALID FOR ONE MONTH OF EA PLAY PRO ("PRODUCT") FROM THE ORIGIN STORE (origin.com).   MAY NOT BE COMBINED WITH ANY OTHER PROMOTIONAL OR DISCOUNT OFFER, UNLESS EXPRESSLY AUTHORIZED BY EA; MAY NOT BE COMBINED WITH ANY PREPAID CARD REDEEMABLE FOR THE APPLICABLE CONTENT.   LIMIT ONE CODE PER PERSON.  OFFER MAY NOT BE SUBSTITUTED, EXCHANGED, SOLD OR REDEEMED FOR CASH OR OTHER GOODS OR SERVICES.   VOID WHERE PROHIBITED, TAXED OR RESTRICTED BY LAW.
            </p>
            <p>
                * THIS OFFER IS BEING ISSUED TO YOU FOR PROMOTIONAL PURPOSES ONLY AND DOES NOT HAVE A CASH VALUE.  SINGLE-USE CODE EXPIRES ON [09/24/2021]. CODE VALID FOR TWELVE MONTHS OF EA PLAY PRO ("PRODUCT") FROM THE ORIGIN STORE (origin.com).   MAY NOT BE COMBINED WITH ANY OTHER PROMOTIONAL OR DISCOUNT OFFER, UNLESS EXPRESSLY AUTHORIZED BY EA; MAY NOT BE COMBINED WITH ANY PREPAID CARD REDEEMABLE FOR THE APPLICABLE CONTENT.   LIMIT ONE CODE PER PERSON.  OFFER MAY NOT BE SUBSTITUTED, EXCHANGED, SOLD OR REDEEMED FOR CASH OR OTHER GOODS OR SERVICES.   VOID WHERE PROHIBITED, TAXED OR RESTRICTED BY LAW.
            </p>
        </div>
    </div>
</section>
@endsection