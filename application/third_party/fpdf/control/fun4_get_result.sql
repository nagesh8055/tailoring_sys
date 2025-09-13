| fun4_get_result | STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTI
ON | CREATE DEFINER=`lagnakara_com_u`@`%` FUNCTION `fun4_get_result`() RETURNS t
inyint(4)
begin
        return @res;
end | latin1               | latin1_swedish_ci    | latin1_swedish_ci  |