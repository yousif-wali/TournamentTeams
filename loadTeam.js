fetch("src/updateMembers.php").then(res=>res.text())
fetch("src/updateTeams.php").then(res=>res.text())
const memberDemo = (name, member, role)=>{
    window.location = `api/memberInfo/memberdemo.php?teamName=${name}&memberName=${member}&role=${role}`
}