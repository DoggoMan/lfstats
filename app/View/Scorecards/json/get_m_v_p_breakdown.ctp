<?php
    $mvp = array();

    switch ($score['Scorecard']['position']) {
        case "Ammo Carrier":
            $mvp['Position Score Bonus'] = max((floor(($score['Scorecard']['score']-3000)/10)*.01), 0);
            break;
        case "Commander":
            $mvp['Position Score Bonus'] = max((floor(($score['Scorecard']['score']-10000)/10)*.01), 0);
            $mvp['Missiled Opponent'] = $score['Scorecard']['missiled_opponent'];
            break;
        case "Heavy Weapons":
            $mvp['Position Score Bonus'] = max((floor(($score['Scorecard']['score']-7000)/10)*.01), 0);
            $mvp['Missiled Opponent'] = $score['Scorecard']['missiled_opponent'] * 2;
            break;
        case "Medic":
            $mvp['Position Score Bonus'] = max((floor(($score['Scorecard']['score']-2000)/10)*.01), 0);
            break;
        case "Scout":
            $mvp['Position Score Bonus'] = max((floor(($score['Scorecard']['score']-6000)/10)*.01), 0);
            break;
    }

    $elimBonus = 0;
    if ($score['Scorecard']['elim_other_team']) {
        if (is_null($score['Game']['game_length'])) {
            $elimBonus = $score['Scorecard']['elim_other_team'] * 2;
        } else {
            $elimBonus = max(1, round(((900 - $score['Game']['game_length']) / 60), 2));
        }
    }
    
    $mvp['Accuracy'] = round($score['Scorecard']['accuracy'] * 10, 1);
    $mvp['Nukes Detonated'] = $score['Scorecard']['nukes_detonated'];
    $mvp['Nukes Canceled'] = $score['Scorecard']['nukes_canceled']*3;
    $mvp['Medic Hits'] = $score['Scorecard']['medic_hits'];
    $mvp['Own Medic Hits'] = $score['Scorecard']['own_medic_hits']*-1;
    $mvp['Activate Rapid Fire'] = $score['Scorecard']['scout_rapid']*.5;
    $mvp['Shoot 3-Hit'] = (floor(($score['Scorecard']['shot_3hit']/6)*100) / 100);
    $mvp['Ammo Boost'] = $score['Scorecard']['ammo_boost'] * 3;
    $mvp['Life Boost'] = $score['Scorecard']['life_boost'] * 2;
    $mvp['Medic Survival Bonus'] = ($score['Scorecard']['lives_left'] > 0 && $score['Scorecard']['position'] == "Medic") ? 2 : 0;
    $mvp['Medic Score Bonus'] = ($score['Scorecard']['position'] == 'Medic' && $score['Scorecard']['score'] >= 3000) ? 1 : 0;
    $mvp['Elimination Bonus'] = $elimBonus;
    $mvp['Times Missiled'] = $score['Scorecard']['times_missiled']*-1;
    $mvp['Missiled Team'] = $score['Scorecard']['missiled_team']*-3;
    $mvp['Your Nukes Canceled'] = ($score['Scorecard']['nukes_activated'] - $score['Scorecard']['nukes_detonated'])*-3;
    $mvp['Team Nukes Canceled'] = $score['Scorecard']['own_nuke_cancels'] * -3;
    $mvp['Elimination Penalty'] = ($score['Scorecard']['lives_left'] <= 0 && $score['Scorecard']['position'] != 'Medic') ? -1 : 0;
    
    $mvp['Penalties'] = 0;
    foreach ($score['Penalty'] as $penalty) {
        if ($penalty['type'] != 'Penalty Removed') {
            $mvp['Penalties'] += $penalty['mvp_value'];
        }
    }
?>
<dl class="row">
    <?php foreach ($mvp as $key => $value): ?>
    <?php if ($value > 0): ?>
    <dt class="col-sm-9 text-nowrap"><?= $key; ?>
    </dt>
    <dd class="col-sm-3 text-success text-right"><?= $value; ?>
    </dd>
    <?php elseif ($value < 0): ?>
    <dt><?= $key; ?>
    </dt>
    <dd class="col-sm-3 text-danger text-right"><?= $value; ?>
    </dd>
    <?php endif; ?>
    <?php endforeach; ?>
    <hr>
    <dt class="col-sm-9">Total</dt>
    <dd class="col-sm-3 text-primary text-right"><?= $score['Scorecard']['mvp_points']; ?>
    </dd>
</dl>