
BEGIN

	 DECLARE finished INTEGER DEFAULT 0;
     DECLARE cchall_id INTEGER DEFAULT 0;

    -- declare challid for when chall reach due
     DEClARE curChall_ID
     CURSOR FOR 
     	SELECT `chall_id` FROM challenges where `chall_due_date` = CURRENT_DATE
     	AND `winner_fk` = '0';
        
        -- declare NOT FOUND handler
    DECLARE CONTINUE HANDLER 
        FOR NOT FOUND SET finished = 1;
 
    OPEN curChall_ID;
 
    updateChallDue: LOOP
        FETCH curChall_ID INTO cchall_id;
        IF finished = 1 THEN 
            LEAVE updateChallDue;
        END IF;
        SELECT SUM(player1_score) INTO @play1 FROM challenge_record WHERE fk_challenge_id = cchall_id;
        SELECT SUM(player2_score) INTO @play2 FROM challenge_record WHERE fk_challenge_id = cchall_id;
        SELECT SUM(player3_score) INTO @play3 FROM challenge_record WHERE fk_challenge_id = cchall_id;
        SELECT SUM(player4_score) INTO @play4 FROM challenge_record WHERE fk_challenge_id = cchall_id;
        SELECT SUM(player5_score) INTO @play5 FROM challenge_record WHERE fk_challenge_id = cchall_id;

        if (@play1 > @play2) AND (@play1 > @play3) AND (@play1 > @play4) AND (@play1 > @play5) 	THEN 
            SELECT `chall_creator_fk` INTO @winner_id FROM challenges WHERE chall_id = cchall_id;  END IF;
        if (@play2 > @play1) AND (@play2 > @play3) AND (@play2 > @play4) AND (@play2 > @play5) 	THEN 
            SELECT `chall_invite2` INTO @winner_id FROM challenges WHERE chall_id = cchall_id;  END IF;
        if (@play3 > @play2) AND (@play3 > @play1) AND (@play3 > @play4) AND (@play3 > @play5) 	THEN 
            SELECT `chall_invite3` INTO @winner_id FROM challenges WHERE chall_id = cchall_id;  END IF;
        if (@play4 > @play3) AND (@play4 > @play2) AND (@play4 > @play1) AND (@play4 > @play5) 	THEN 
            SELECT `chall_invite4` INTO @winner_id FROM challenges WHERE chall_id = cchall_id;  END IF;
        if (@play5 > @play4) AND (@play5 > @play3) AND (@play5 > @play2) AND (@play5 > @play1) 	THEN 
            SELECT `chall_invite5` INTO @winner_id FROM challenges WHERE chall_id = cchall_id;  END IF;          

        -- SET emailList = CONCAT(emailAddress,";",emailList);
        UPDATE challenges SET winner_fk = @winner_id WHERE chall_id = cchall_id;
    END LOOP updateChallDue;
    CLOSE curChall_ID;
    commit;

END
