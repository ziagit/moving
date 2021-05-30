export default {
    formatPhone(entry = "") {
        const match = entry
          .replace(/\D+/g, "")
          .replace(/^1/, "")
          .match(/([^\d]*\d[^\d]*){1,10}$/)[0];
        const part1 = match.length > 2 ? `(${match.substring(0, 3)})` : match;
        const part2 = match.length > 3 ? ` ${match.substring(3, 6)}` : "";
        const part3 = match.length > 6 ? `-${match.substring(6, 10)}` : "";
        return `${part1}${part2}${part3}`;
      },
}